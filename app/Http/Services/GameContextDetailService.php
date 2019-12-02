<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\GameContextDetail;

class GameContextDetailService extends Base
{
    public $model;

    public function __construct(GameContextDetail $model)
    {
        $this->model = $model;
    }

    function update($request)
    {
        $this->model->where('game_context_id', $request->id)->delete();
        $data = json_decode($request->children_options, true);
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['game_context_id'] = $request->id;
            $data[$i]['width'] = ceil($data[$i]['width']);
            $data[$i]['height'] = ceil($data[$i]['height']);
            $data[$i]['left'] = ceil($data[$i]['left']);
            $data[$i]['top'] = ceil($data[$i]['top']);
            $this->model->create($data[$i]);
        }
        return true;
    }
}

