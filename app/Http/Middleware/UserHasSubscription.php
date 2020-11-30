<?php

namespace App\Http\Middleware;

use Closure;

class UserHasSubscription
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
        if ($request->user()->isActiveSubscription()) {
            return $next($request);
        }
        return response()->json([
            'success' => false,
            'message' => 'User has no active subscriptions'
        ]);
    }
}
