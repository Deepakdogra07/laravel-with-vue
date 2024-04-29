<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ): Response
    {
        if(auth()->user()){
            $user_type = auth()->user()->user_type;
            if($user_type == 2){
                return redirect()->route('business-dash');
            }elseif($user_type == 1){
                return $next($request);
            }
        }
        return $next($request);
    }
}
