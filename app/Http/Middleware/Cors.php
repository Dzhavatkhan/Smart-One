<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Проверяем, что $response является экземпляром Illuminate\Http\Response
        if ($response instanceof \Illuminate\Http\Response) {
            $response->header('Access-Control-Allow-Origin', '*'); // или ваш конкретный домен
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-Auth-Token, Authorization');
        }

        return $response;
    }
}
