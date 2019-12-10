<?php

namespace App\Http\Services;

use App\Consts;
use Illuminate\Support\Facades\Cache;

class BaseService
{
    public function getList($request)
    {
        return $this->basePagination($request);
    }

    public function getAll($with = array())
    {
        return $this->model->with($with)->get();
    }

    public function store($request)
    {
        $params = $this->getParams($request);
        $result = $this->model->create($params);
        $this->clearCacheMasterData();
        return $result;
    }

    public function update($request)
    {
        $params = $this->getParams($request);
        $result = $this->model->where('id', $this->getID($request))
            ->update($params);
        $this->clearCacheMasterData();
        return $result;
    }

    public function updateField($request)
    {
        $params = $request->all();
        $result = $this->model->where('id', $params['id'])
            ->update([$params['fieldUpdate'] => $params['value']]);
        $this->clearCacheMasterData();
        return $result;
    }

    public function destroy($request)
    {
        $result = $this->model->find($this->getID($request))
            ->delete();
        $this->clearCacheMasterData();
        return $result;
    }

    public function destroyWhere($key, $str, $value)
    {
        $result = $this->model->where($key, $str, $value)
            ->delete();
        $this->clearCacheMasterData();
        return $result;
    }

    public function getID($request)
    {
        return $request->id;
    }

    public function getParams($request)
    {
        $fillable = $this->getFillable();
        return $request->only($fillable);
    }

    public function getFillable()
    {
        return $this->model->getFillable();
    }

    public function basePagination($request, $query = '')
    {
        $params = $this->parseParams($request);
        $baseQuery = $query ?: $this->model;

        if ($params['user_id']) {
            $baseQuery = $baseQuery->where('user_id', $params['user_id']);
        }
        return $baseQuery->orderBy($params['sort'], $params['sortType'])
            ->paginate($params['limited']);
    }

    private function parseParams($request)
    {
        return [
            'limited' => $request['limit'] ?: Consts::LIMITED,
            'sortType' => trim(substr($request['sort'], 0, 1)) === Consts::PLUS ? 'ASC' : 'DESC',
            'sort' => substr($request['sort'], 1),
            'user_id' => isset($request['user_id']) ? $request['user_id'] : ''
        ];
    }

    private function clearCacheMasterData()
    {
        return Cache::forget('masterData');
    }
}
