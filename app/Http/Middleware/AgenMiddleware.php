<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('agen')->check()) {
            return redirect('/agen/login');
        }
        return $next($request);
    }
}