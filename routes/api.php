<?php
use Illuminate\Support\Facades\Route;
 //v1 controllers
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\TaskController;

// /api/v1/
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    //AuthController
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware('auth:sanctum');

   //TaskController
    Route::apiResource('/tasks', TaskController::class)->names('api.tasks');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('api.toggle');

});
