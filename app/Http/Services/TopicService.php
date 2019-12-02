<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Topic;

class TopicService extends Base
{
    public $model;

    public function __construct(Topic $model)
    {
        $this->model = $model;
    }
}

