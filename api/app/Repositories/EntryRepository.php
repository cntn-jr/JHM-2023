<?php

namespace App\Repositories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Collection;

class EntryRepository {

    /**
     * 全ての応募情報を取得する
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Entry::all();
    }
}