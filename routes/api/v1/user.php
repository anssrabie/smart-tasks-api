<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

// Profile
Route::post('auth/logout', [AuthController::class,'logout']);

// Tasks
Route::resource('tasks',TaskController::class);
Route::prefix('tasks/{id}')->group(function () {
    Route::patch('assign', [TaskController::class, 'assign'])->name('tasks.assign');
    Route::patch('status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

// Status
Route::get('statuses',StatusController::class);
