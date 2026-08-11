<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanApprove
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->canApprove()) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan persetujuan ini.');
        }

        return $next($request);
    }
}
