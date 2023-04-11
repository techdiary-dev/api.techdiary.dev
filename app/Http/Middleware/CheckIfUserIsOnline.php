<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckIfUserIsOnline
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('user')) {
            $key = 'user-is-online-'.$request->user()->id;
            Cache::put($key, true, Carbon::now()->addMinute(1));
        }

        return $next($request);
    }
}
