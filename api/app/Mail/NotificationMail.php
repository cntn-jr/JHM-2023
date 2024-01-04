<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $title;
    private string $content;

    /**
     * Create a new message instance.
     */
    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = !App::environment('local')
            ? 'JHM-2023 '
            : '【local】 JHM-2023 ';
        $subject = $subject . $this->title;

        return $this->view('mails.notification')
            ->to('chinochinotin@gmail.com')
            ->from('ychrshk.kbc19a21@gmail.com', 'jhm-2023') //送り元アドレス
            ->subject($subject)
            ->with(['messageBody' => $this->content]);
    }
}
