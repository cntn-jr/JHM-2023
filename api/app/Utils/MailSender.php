<?php

namespace App\Utils;

use App\Mail\NotificationMail;
use App\Repositories\MessageRepository;
use Illuminate\Support\Facades\Mail;

class MailSender {

    public function __construct(private readonly ?MessageRepository $messageRepository)
    {}

    /**
     * メッセージを指定し、送信する
     *
     * @param integer $messageMasterId
     * @param array $replacement
     * @return void
     */
    public function sendNotification(int $messageMasterId, array $replacement) :void
    {

        // メッセージを取得する
        $message = $this->messageRepository
            ->find($messageMasterId);

        // メッセージに値を埋め込む
        $messageBody = str_replace(array_keys($replacement), array_values($replacement), $message->content);

        // メールを送信する
        Mail::send(new NotificationMail($message->title, $messageBody));
    }
}