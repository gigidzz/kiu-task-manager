<?php

use App\Http\Controllers\Api\TaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes (stateless, token-authenticated via Laravel Sanctum)
|--------------------------------------------------------------------------
*/

// Issue an API token in exchange for valid credentials.
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (! $user || ! Hash::check($credentials['password'], $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
        'user'  => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
    ]);
});

// Protected endpoints — require a valid Bearer token.
// The `api.` name prefix keeps these route names from colliding with the
// web `tasks.*` routes (so route('tasks.index') still resolves to /tasks).
Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());

    Route::apiResource('tasks', TaskController::class);
});
