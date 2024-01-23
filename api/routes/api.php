<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::post('tokens/{user}', [\App\Http\Controllers\FirebasePushController::class, 'setToken'])->name('firebase.token');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('notification', [\App\Http\Controllers\FirebasePushController::class, 'notification'])->name('firebase.notification');

    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
});
