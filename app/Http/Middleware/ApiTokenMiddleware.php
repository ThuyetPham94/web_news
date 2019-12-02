<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LOG;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ApiTokenMiddleware
{

    public function handle($request, Closure $next)
    {
        LOG::logRequest((new \DateTime())->format('Y-m-d H:i:s')."\n".$request);
        try {
            $user = JWTAuth::parseToken()->authenticate();
            // if($user->id != $request->UserID)
            // {
            //     return response()->json(array('code' => 501, 'message' => "Your token is invalid. Please try again",'result'=>(object)array()));
            // }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(array('code' => 401, 'message' => "Your token is invalid",'result'=>(object)array()));
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(array('code' => 401, 'message' => "Your token is expired",'result'=>(object)array()));
            }else{
                return response()->json(array('code' => 401, 'message' => "The token is not found",'result'=>(object)array()));
            }
        }
        return $next($request);
    }
}
