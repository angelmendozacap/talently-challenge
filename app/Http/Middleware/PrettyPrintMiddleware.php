<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PrettyPrintMiddleware
{
    private const QUERY_PARAMETER = 'pretty';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            if (!$request->query(self::QUERY_PARAMETER) || $request->query(self::QUERY_PARAMETER) == 'true') {
                $response->setEncodingOptions(JSON_PRETTY_PRINT);
            }
        }

        return $response;
    }
}
