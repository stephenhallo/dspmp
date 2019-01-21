<?php

namespace App\Http\Middleware;

use Closure;

class checkOperater
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
        if ($loginMember->type != 2) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
