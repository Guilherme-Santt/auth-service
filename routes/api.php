<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    $users = \App\Models\User::all();
    return ['message' => 'Welcome to the API', 'users' => $users];
});

Route::post('/login', [AuthController::class, 'login']); 

Route::middleware(['redis.auth'])->group(function () {
    Route::get('/me', function (Request $request) {
        
        return response()->json([
            'message' => 'Você está autenticado!',
            'user_id' => $request->auth_user_id,
            'user' => \App\Models\User::find($request->auth_user_id)
        ]);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
});
