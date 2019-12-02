<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Carbon\Carbon;

class CheckExpire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $result = Carbon::parse($user->expire_time)->gt(Carbon::now());
            if($result){
                return $next($request);
            }else{
                return response()->json(array('code' => 501, 'message' => "Your account is expired. Please use our service to re-active your account",'result'=>(object)array()));
            }
        } catch (\Exception $e) {
            return response()->json(array('code' => 501, 'message' => "We could not get your information. Please try again",'result'=>(object)array()));            
        }
    }
}
