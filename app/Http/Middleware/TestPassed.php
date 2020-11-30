<?php

namespace App\Http\Middleware;

use App\Models\Test;
use Closure;

class TestPassed
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
        $test = $request->route()->parameter('test');
        /** @var Test $previousTest */
        $previousTest = $test->previous();
        if (!$previousTest || $previousTest->passedResults()->count() > 0) {
            return $next($request);
        }
        return response()->json([
            'success' => false,
            'message' => 'Доступ запрещен',
        ]);
    }
}
