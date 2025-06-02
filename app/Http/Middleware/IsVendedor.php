<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVendedor
{
    public function handle(Request $request, Closure $next): Response{
       if (auth()->check() && in_array(auth()->user()->role, ['vendedor', 'admin'])) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
