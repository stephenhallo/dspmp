<?php

namespace App\Http\Middleware;

use Closure;

class checkArtister
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
        $loginMember = auth('member')->user();
        if ($loginMember->type != 1) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
