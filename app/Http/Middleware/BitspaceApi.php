<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BitspaceApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty($request->header('Authorization')) || !$request->ajax()) {
            $header = base64_decode(substr($request->header('Authorization'), 6));
            if ($header === config('app.auth_key')) return $next($request);
        }

        return response()->json(['error' => 'Forbidden'],403);
    }
}
