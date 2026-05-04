<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        Log::info('API request', [
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
            'status' => $response->getStatusCode(),
            'user'   => $request->user()?->id,
        ]);

        return $response;
    }
}
