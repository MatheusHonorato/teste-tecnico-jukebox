<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::post('setToken', [\App\Http\Controllers\FirebasePushController::class, 'setToken'])->name('firebase.token');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('send/notification', [\App\Http\Controllers\FirebasePushController::class,'notification'])->name('firebase.send');

    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
});
