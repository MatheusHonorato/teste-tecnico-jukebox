<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('timezone.difference');

Route::post('users/{user}/tokens', [\App\Http\Controllers\UserController::class, 'setToken'])->name('users.token');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('notifications', [\App\Http\Controllers\FirebasePushController::class, 'notification'])->name('firebase.notification');

    Route::apiResource('tasks', \App\Http\Controllers\TaskController::class)->middleware('add.user_id');
});
