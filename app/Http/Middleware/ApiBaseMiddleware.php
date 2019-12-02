<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\LOG;
use JWT;

class ApiBaseMiddleware
{

    public function handle($request, Closure $next)
    {
    	LOG::logRequest((new \DateTime())->format('Y-m-d H:i:s')."\n".$request);
        return $next($request);
    }

}
