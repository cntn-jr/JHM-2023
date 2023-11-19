<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class CsvHandler {

    public static function isCsvExtension($file): bool
    {
        return $file->extension() == "csv";
    }

    public function getFile()
    {
        return Storage::disk('local')->get('a');
    }
}