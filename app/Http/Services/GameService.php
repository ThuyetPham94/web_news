<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Game;

class GameService extends Base
{
    public $model;

    public function __construct(Game $model)
    {
        $this->model = $model;
    }
}

