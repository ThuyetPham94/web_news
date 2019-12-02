<?php

namespace App\Http\Controllers\ApiWeb;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function getList(Request $request)
    {
        try {
            $result = $this->service->getList($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $result = $this->service->getAll();
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function appendToRequest($request, $data)
    {
        foreach ($data as $key => $value) {
            $request[$key] = $value;
        }
        return $request;
    }

    public function store(Request $request)
    {
        try {
            $result = $this->service->store($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $result = $this->service->update($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function updateField(Request $request)
    {
        try {
            $result = $this->service->updateField($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $result = $this->service->destroy($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function sendResponse($result, $message = null)
    {
        $res = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($res);
    }

    public function sendError($error, $code = 404)
    {
        $res = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($res, $code);
    }
}
