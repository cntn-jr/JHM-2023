<?php

namespace App\Const;

class SelectionStatus {

    const CASUAL_INTERVIEW            = 0;
    const BRIEFING                    = 1;
    const DOCUMENT_SCREENING          = 2;
    const DIRECT_GROUP_INTERVIEW      = 3;
    const ONLINE_GROUP_INTERVIEW      = 4;
    const DIRECT_INDIVIDUAL_INTERVIEW = 5;
    const ONLINE_INDIVIDUAL_INTERVIEW = 6;
    const DIRECT_PRESIDENT_INTERVIEW  = 7;
    const ONLINE_PRESIDENT_INTERVIEW  = 8;
    const OTHER                       = 100;

    const LABELS = [
        self::CASUAL_INTERVIEW            => 'カジュアル面談',
        self::BRIEFING                    => '説明会',
        self::DOCUMENT_SCREENING          => '書類選考',
        self::DIRECT_GROUP_INTERVIEW      => 'グループ面接（現地）',
        self::ONLINE_GROUP_INTERVIEW      => 'グループ面接（オンライン）',
        self::DIRECT_INDIVIDUAL_INTERVIEW => '個人面接（現地）',
        self::ONLINE_INDIVIDUAL_INTERVIEW => '個人面接（オンライン）',
        self::DIRECT_PRESIDENT_INTERVIEW  => '社長面接（現地）',
        self::ONLINE_PRESIDENT_INTERVIEW  => '社長面接（オンライン）',
        self::OTHER                       => 'その他',
    ];

    const ALL = [
        self::CASUAL_INTERVIEW,
        self::BRIEFING,
        self::DOCUMENT_SCREENING,
        self::DIRECT_GROUP_INTERVIEW,
        self::ONLINE_GROUP_INTERVIEW,
        self::DIRECT_INDIVIDUAL_INTERVIEW,
        self::ONLINE_INDIVIDUAL_INTERVIEW,
        self::DIRECT_PRESIDENT_INTERVIEW,
        self::ONLINE_PRESIDENT_INTERVIEW,
        self::OTHER,
    ];

}