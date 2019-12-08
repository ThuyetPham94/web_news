<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Tag;

class TagService extends Base
{
    public $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }
}

