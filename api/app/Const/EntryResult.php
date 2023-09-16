<?php

namespace App\Const;

class EntryResult {

    const IN_SELECTION             = 0;
    const PASSING                  = 1;
    const FAILURE                  = 2;
    const UNOFFICIAL_OFFER_REFUSAL = 3;
    const UNOFFICIAL_OFFER_RESET   = 4;

    const LABELS = [
        self::IN_SELECTION             => '選考中',
        self::PASSING                  => '合格',
        self::FAILURE                  => '落選',
        self::UNOFFICIAL_OFFER_REFUSAL => '内定辞退',
        self::UNOFFICIAL_OFFER_RESET   => '内定取消',
    ];

    const ALL = [
        self::IN_SELECTION,
        self::PASSING,
        self::FAILURE,
        self::UNOFFICIAL_OFFER_REFUSAL,
        self::UNOFFICIAL_OFFER_RESET,
    ];
}