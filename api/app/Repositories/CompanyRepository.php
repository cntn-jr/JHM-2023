<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository {

    /**
     * 指定した学校で登録された企業を取得
     *
     * @param integer $school_id
     * @return void
     */
    public function findScopedSchool(int $school_id) :Collection
    {
        return Company::query()
            ->school($school_id)
            ->get();
    }
}