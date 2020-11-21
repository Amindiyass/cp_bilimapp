<?php

namespace App\Http\Middleware;

use Closure;


class ExcludeObligationOfAccept
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->headers->get('accept'), ['application/json', 'Application/Json']))
            return response()->json(['message' => 'Unauthenticated. You have to specify in header param Accept -> application/json'], 401);

        return $next($request);
    }
}
