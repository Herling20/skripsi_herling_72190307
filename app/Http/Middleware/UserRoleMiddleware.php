<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(auth()->dosen()->role == $role)
        {
            return $next($request);
        }
        else if (auth()->mahasiswa()->role == $role)
        {
            return $next($request);
        }
        
        return response()->json(["You don't have permission!"]);   
    }
}
