<?php

namespace App\Http\Controllers\ApiWeb;

use Illuminate\Http\Request;
use App\Http\Services\WordService;
use App\Http\Controllers\ApiWeb\BaseController as Base;
use App\Http\Services\UploadImageService;
use App\Imports\WordImport;
use Excel;

class WordController extends Base
{
    public $service;
    public $upload;

    public function __construct(WordService $service, UploadImageService $upload)
    {
        $this->service = $service;
        $this->upload = $upload;
    }

    private function appendImageAndAudio($request)
    {
        $data = [];
        $request->file ? $data['photo'] = $this->upload->upload($request, 'file') : $data;
        $request->audio_vi ? $data['audio_vi'] = $this->upload->upload($request, 'audio_vi') : $data;
        $request->audio_en ? $data['audio_en'] = $this->upload->upload($request, 'audio_en') : $data;
        return $this->appendToRequest($request, $data);
    }

    public function store(Request $request)
    {
        try {
            $request = $this->appendImageAndAudio($request);
            $request['word_system_id'] = 0;
            $result = $this->service->store($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::import(new WordImport, request()->file('file'));
        }
    }

    public function update(Request $request)
    {
        try {
            $request = $this->appendImageAndAudio($request);
            $request['word_system_id'] = 0;
            $result = $this->service->update($request);
            return $this->sendResponse($result);
        } catch (Exception $ex) {
            logger()->error($ex);
            return $this->sendError($ex->getMessage());
        }
    }
}
