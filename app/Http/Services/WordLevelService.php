<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\WordLevel;

class WordLevelService extends Base
{
    public $model;

    public function __construct(WordLevel $model)
    {
        $this->model = $model;
    }

    public function getAll($myWordId = null)
    {
        if ($myWordId) {
            return $this->model->where('id', '<>', $myWordId)->get();
        }
        return $this->model->all();
    }
}

