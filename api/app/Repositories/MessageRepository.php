<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository {

    /**
     * メールメッセージを取得する
     *
     * @param integer $id
     * @return Message
     */
    public function find(int $id) :Message
    {
        return Message::query()
            ->where('message_master_id', $id)
            ->first();
    }
}
