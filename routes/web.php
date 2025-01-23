<?php

use App\Http\Controllers\SessionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('index');

Route::middleware('auth')->group(function () {
    Route::resource('task', TaskController::class);
    Route::patch('/task/{task}/status', [TaskStatusController::class, 'update'])->name('task.status');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'login'])->name('login');
    Route::get('/register', [SessionController::class, 'register'])->name('register');
});

require __DIR__.'/auth.php';
