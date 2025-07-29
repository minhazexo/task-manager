<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|--------------------------------------------------------------------------
*/

// ✅ Public Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ Protected Routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {

    // 🔹 Auth-related routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();  // Returns logged-in user info
    });

    // 🔹 Task routes (CRUD)
    Route::apiResource('tasks', TaskController::class);
    // This automatically creates:
    // GET    /tasks         → index()
    // POST   /tasks         → store()
    // GET    /tasks/{id}    → show()
    // PUT    /tasks/{id}    → update()
    // DELETE /tasks/{id}    → destroy()
});
