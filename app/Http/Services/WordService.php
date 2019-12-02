<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Words;

class WordService extends Base
{
    public $model;

    public function __construct(Words $model)
    {
        $this->model = $model;
    }
}

