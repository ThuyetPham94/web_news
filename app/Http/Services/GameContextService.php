<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\GameContext;

class GameContextService extends Base
{
    public $model;

    public function __construct(GameContext $model)
    {
        $this->model = $model;
    }

    public function find($request)
    {
        return $this->model->find($request->id);
    }
}

