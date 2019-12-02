<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Consts;

class UploadImageService
{
    private $uploads_dir = '/upload/';
    private $type = 'image';

    public function uploadDir()
    {
        return getcwd() . $this->uploads_dir . $this->type;
    }

    public function upload(Request $request, $keyUpload = 'file')
    {
        $file = $request[$keyUpload];
        if (is_file($file)) {
            $mimeType = $file->getClientMimeType();
            $fileName = str_replace(".", "", microtime(true)) . '.' . $file->getClientOriginalExtension();
            if ( strstr( $mimeType, 'audio' ) ) {
                $this->type = 'audio';
            }
            try {
                $file->move($this->uploadDir(), $fileName);
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
            return $fileName;
        }
        return false;
    }
}
