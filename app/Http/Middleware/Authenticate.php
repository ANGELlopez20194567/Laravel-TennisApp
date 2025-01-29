<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        
        $user=Auth::user();

        if ($request->is('logout')) {
            return $next($request);
        }

        if($user->role==1){
            return $next($request);
        }

        if($user->role==2){
            return redirect('/vendedor');
        }
    }
}
