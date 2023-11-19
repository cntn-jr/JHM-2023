<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CsvHandler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CsvHandler';
    }
}