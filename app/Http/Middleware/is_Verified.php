<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class is_Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $is_verified=User::where('phoneNum',$request['phoneNum'])->select('isVerified')->first();
//        dd($is_verified['isVerified']);
        if(!$is_verified['isVerified'])
            return response('you have to verify your email in order to log in into the system.',403);
        return $next($request);
    }
}
