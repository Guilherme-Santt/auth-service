<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(!$request->email && !$request->password) {
            return response()->json(['message' => 'Email e senha são obrigatórios'], 400);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) ) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Str::random(64);

        Redis::setex("token:$token", 3600, $user->id);

        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            Redis::del("token:$token");
        }

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function user(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token não fornecido'], 401);
        }

        $userId = Redis::get("token:$token");

        if (!$userId) {
            return response()->json(['message' => 'Token inválido ou expirado'], 401);
        }

        $user = User::find($userId);

        return response()->json($user);
    }
    
}
