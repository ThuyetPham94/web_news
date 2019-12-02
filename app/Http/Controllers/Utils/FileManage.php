<?php
namespace App\Http\Controllers\Utils;

use Carbon\Carbon;
use Config;
/**
 * Class JsonResponse
 * Simple response object for Laravue application
 * Response format:
 * {
 *   'success': true|false,
 *   'data': [],
 *   'error': ''
 * }
 *
 * @package Ultis
 */
class FileManage
{
    /**
	 * function store image
	 * @param file $fileToSave
	 * @param integer $type
	 * 
	 * @return where
	 */
	static function saveFile($fileToSave, $type = 1, $url = "")
    {
        if($url != "" && $url != null)
        {
            return $url;
        }
        if($fileToSave)
        {
            $fileExt = $fileToSave->getClientOriginalExtension();
            if($type == 1)
            {
                $pathFolder = Config::get('constants.path_upload');
            }
            else
            {
                $pathFolder = Config::get('constants.path_upload_audio');
            }
            if(!file_exists($pathFolder)){
                mkdir($pathFolder,0777,TRUE);
            }
            $filename = rand(11111, 99999) . '_' . time() . '.' . $fileExt;       
            $fileToSave->move($pathFolder, $filename);   
            return $filename;
        }
        else
        {
            return '';
        }
    }

    /**
	 * function get full direct image
	 * @param string $photo
	 * 
	 * @return string
	 */
    static function getPhotoURL($photo)
    {
        if(substr(trim($photo), 0,4) === 'http'){
            return $photo;
        }else if($photo != null && $photo != ''){
            return Config::get('constants.base_domain').$photo;
        }
    }

    /**
	 * function get full direct image
	 * @param string $photo
	 * 
	 * @return string
	 */
    static function getAudioURL($audio)
    {
        if(substr(trim($audio), 0,4) === 'http'){
            return $audio;
        }else if($audio != null && $audio != ''){
            return Config::get('constants.base_domain_audio').$audio;
        }
    }
}
