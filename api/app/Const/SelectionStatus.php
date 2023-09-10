<?php

namespace App\Const;

class SelectionStatus {

    const CASUAL_INTERVIEW    = [
        'id'   => 0,
        'name' => 'カジュアル面談',
    ];
    const BRIEFING            = [
        'id'   => 1,
        'name' => '説明会',
    ];
    const DOCUMENT_SCREENING  = [
        'id'   => 2,
        'name' => '書類選考',
    ];
    const ELECTIVE_EXAM_1     = [
        'id'   => 3,
        'name' => '１次選考',
    ];
    const ELECTIVE_EXAM_2     = [
        'id'   => 4,
        'name' => '２次選考',
    ];
    const ELECTIVE_EXAM_3     = [
        'id'   => 5,
        'name' => '３次選考',
    ];
    const ELECTIVE_EXAM_4     = [
        'id'   => 6,
        'name' => '４次選考',
    ];
    const ELECTIVE_EXAM_5     = [
        'id'   => 7,
        'name' => '５次選考',
    ];
    const ELECTIVE_EXAM_OTHER = [
        'id'   => 8,
        'name' => '６次選考以降',
    ];
    const UNOFFICIAL_OFFER    = [
        'id'   => 9,
        'name' => '内定（内々定）',
    ];
    const FAILURE             = [
        'id'   => 10,
        'name' => '不合格',
    ];
    const OTHER               = [
        'id'   => 100,
        'name' => 'その他',
    ];

    const ALL = [
        self::CASUAL_INTERVIEW   ,
        self::BRIEFING           ,
        self::DOCUMENT_SCREENING ,
        self::ELECTIVE_EXAM_1    ,
        self::ELECTIVE_EXAM_2    ,
        self::ELECTIVE_EXAM_3    ,
        self::ELECTIVE_EXAM_4    ,
        self::ELECTIVE_EXAM_5    ,
        self::ELECTIVE_EXAM_OTHER,
        self::UNOFFICIAL_OFFER   ,
        self::FAILURE            ,
    ];

}