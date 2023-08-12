<?php

namespace App\Const;

class Role {
    public const ADMINISTRATOR = 1;
    public const MANAGER = 2;
    public const TEACHER = 3;
    public const STUDENT = 4;

    public const ROLES = [
        self::ADMINISTRATOR,
        self::MANAGER,
        self::TEACHER,
        self::STUDENT,
    ];
}
