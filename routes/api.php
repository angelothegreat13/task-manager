<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskApiController;
use App\Http\Controllers\Api\V1\Auth\AuthApiController;


Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('/login', [AuthApiController::class, 'login'])->name('login');
    Route::post('/register', [AuthApiController::class, 'register'])->name('register');
    

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::apiResource('tasks', TaskApiController::class);
    });
});
