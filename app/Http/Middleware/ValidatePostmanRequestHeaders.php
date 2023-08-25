<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePostmanRequestHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requiredHeaders = [
            'module',
            'platform',
            'operating-system-version',
            'client-version',
            'language',
            'device-id',
            'secure-key',
        ];

        foreach ($requiredHeaders as $header) {
            if (!$request->header($header)) {
                return response()->json(['error' => 'Required header missing: ' . $header], 400);
            }
        }

        // Continue with the request if all required headers are present
        return $next($request);
    }
}
