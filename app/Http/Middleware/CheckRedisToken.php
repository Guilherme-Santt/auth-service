<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckRedisToken
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Pega o token do Header Authorization (Bearer Token)
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token não fornecido'], 401);
        }

        $userId = Redis::get("token:$token");

        if (!$userId) {
            return response()->json(['message' => 'Token inválido ou expirado'], 401);
        }

        $request->merge(['auth_user_id' => $userId]);

        return $next($request);
    }
}