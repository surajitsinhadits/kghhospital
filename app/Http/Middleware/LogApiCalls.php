<?php

namespace App\Http\Middleware;

use App\Models\ApiLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogApiCalls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $apiLog = new ApiLog();
            $apiLog->user_id   = Auth::check() ? Auth::id() : null;
            $apiLog->ip        = $request->ip();
            $apiLog->device_id = $request->header('device-id');
            $apiLog->method    = $request->method();
            $apiLog->route     = $request->path();
            $apiLog->called_at = now();
            $apiLog->save();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Request denied due to logging error ❌',
                'data'    => $e->getMessage()
            ], 503);
        }

        return $next($request);
    }
}
