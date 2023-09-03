<?php

namespace App\Repositories;

use App\Models\School;
use Illuminate\Database\Eloquent\Collection;

class SchoolRepository {

    /**
     * すべての学校情報を取得する
     *
     * @return Collection
     */
    public function findAll() :Collection
    {
        return School::all();
    }
}