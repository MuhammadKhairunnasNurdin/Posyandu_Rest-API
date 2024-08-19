<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!in_array(decrypt(auth()->payload()->get('role')), $roles)) {
            return response()->json([
                'message' => 'user do not have the necessary permissions'
            ], 403);
        }

        return $next($request);
    }
}
