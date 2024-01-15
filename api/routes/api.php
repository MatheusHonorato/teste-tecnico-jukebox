<?php

use Illuminate\Support\Facades\Route;

Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
});
