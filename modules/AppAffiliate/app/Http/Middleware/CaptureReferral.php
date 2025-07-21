<?php

namespace Modules\AppAffiliate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaptureReferral
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('ref')) {
            session(['ref' => $request->query('ref')]);
        }
        return $next($request);
    }
}
