<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Config;
class ApiBaseController extends Controller
{
    protected function returnSuccess($message ,$result = array()){

        return $this->returnJSON(200, $message, $result);
    }

    protected function returnListSuccess($message = "" ,$result = array()){

        return $this->returnListJSON(200, $message, $result);
    }

    protected function returnError($code, $message, $result = array()){
        return $this->returnJSON($code, $message, $result);
    }

    protected function returnErrorPromotion($code, $message, $result = array()){
        return $this->returnJSONPromotion($code, $message, $result);
    }

    protected function returnJSONPromotion($error , $message, $result = "")
    {
        $response = array('code' => $error, 'message' => $message,'promotion_errors'=>$result);
        if (!empty($result)){
            $response['promotion_errors'] = $result;
        }else{
            $empty = (object)array();
            $response['promotion_errors'] =  $empty;
        }
        return Response::json($response);
    }

    protected function returnJSON($error , $message, $result = "")
    {
        $response = array('code' => $error, 'message' => $message,'result'=>$result);
        if (!empty($result)){
            $response['result'] = $result;
        }else{
            $empty = (object)array();
            $response['result'] =  $empty;
        }
        return Response::json($response);
    }


    protected function returnListJSON($error = 0, $message = "", $result = array())
    {
        $response = array('code' => $error, 'message' => $message);
        if (!empty($result)){
            $response['result'] = $result;
        }else{
            $empty = (object)array();
            $response['result'] =  $empty;
        }
        return Response::json($response);
    }

    protected function returnArraySuccess($message ,$result = array()){

        return $this->returnArrayJSON(200, $message, $result);
    }

    protected function returnArrayFailed($message ,$result = array(), $errors = array()){

        return $this->returnArrayJSONFail(404, $message, $result, $errors);
    }

    protected function returnArrayJSONFail($error = 0, $message = "", $result = array(), $errors = array())
    {
        $response = array('code' => $error, 'message' => $message);
        if (!empty($result)){
            $response['result'] = $result;
            $response['errors'] = $errors;
        }else{
            return Response::json(array('code' => 404, 'message' => "",'result'=>array() ,'errors'=>array()));
        }
        return Response::json($response);
    }


    protected function returnArrayJSON($error = 0, $message = "", $result = array())
    {
        $response = array('code' => $error, 'message' => $message);
        if (!empty($result)){
            $response['result'] = $result;
        }else{
            return Response::json(array('code' => 200, 'message' => "",'result'=>array()));
        }
        return Response::json($response);
    }

    protected function returnArrayJSONFailed($code = 0, $message, $result = array())
    {
        $response = array('code' => $code, 'message' => $message);
        if (!empty($result)){
            $response['result'] = $result;
        }else{
            return Response::json(array('code' => $code, 'message' => $message,'result'=>array()));
        }
        return Response::json($response);
    }

    protected function getConstantMessage($message,$language_type)
    {
        if($language_type == 1 || $language_type == null)
        {
            $message = $message.'_vi';
        }
        return $message;
    }

    protected function getLanguage($language_type = 1) {
        if($language_type == 1 || $language_type == null)
        {
            return 'vi';
        }
        return 'en';
    }

    protected function getEnglishName($name,$name_eng,$language_type)
    {
        if($language_type == 2)
        {
            return $name_eng;
        }
        return $name;
    }

}
