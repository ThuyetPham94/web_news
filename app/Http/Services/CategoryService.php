<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Category;

class CategoryService extends Base
{
    public $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}

