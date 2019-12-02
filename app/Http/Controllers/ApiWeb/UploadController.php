<?php

namespace App\Http\Controllers\ApiWeb;

use Illuminate\Http\Request;
use App\Http\Services\UploadImageService;
use App\Http\Controllers\ApiWeb\BaseController as Base;

class UploadController extends Base
{
    public $service;

    public function __construct(UploadImageService $service)
    {
        $this->service = $service;
    }

    public function upload(Request $request)
    {
        try {
            $result = $this->service->upload($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }
}
