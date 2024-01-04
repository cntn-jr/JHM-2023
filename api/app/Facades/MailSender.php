<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MailSender extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MailSender';
    }
}