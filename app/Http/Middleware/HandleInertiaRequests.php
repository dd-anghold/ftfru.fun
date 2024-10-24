<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Closure;

class HandleInertiaRequests extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Добавляем заголовки CORS
        return $response->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->header('Access-Control-Allow-Credentials', 'true');
    }


    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
        ];
    }
}
