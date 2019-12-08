<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Article;

class ArticleService extends Base
{
    public $model;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }
}

