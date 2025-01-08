<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
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
        if (Auth::check() && Auth::user()->estado !== 'Activo') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['inactive' => 'Tu cuenta está inactiva. Contacta al administrador.']);
        }

        return $next($request);
    }
}