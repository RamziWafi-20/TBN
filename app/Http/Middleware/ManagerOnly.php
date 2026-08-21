<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user() && in_array($request->user()->role, ['Pengelola', 'Guru'], true), 403);
        return $next($request);
    }
}
