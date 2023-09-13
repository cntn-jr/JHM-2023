<?php

namespace App\Const;

class EntryResult {

    const IN_SELECTION             = [
        'id'   => 0,
        'name' => '選考中',
    ];
    const PASSING                  = [
        'id'   => 1,
        'name' => '合格',
    ];
    const UNOFFICIAL_OFFER_REFUSAL = [
        'id'   => 2,
        'name' => '内定辞退',
    ];
    const UNOFFICIAL_OFFER_RESET   = [
        'id'   => 3,
        'name' => '内定取消',
    ];

    const ALL = [
        self::IN_SELECTION,
        self::PASSING,
        self::UNOFFICIAL_OFFER_REFUSAL,
        self::UNOFFICIAL_OFFER_RESET,
    ];
}