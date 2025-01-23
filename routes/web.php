<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::resource('task', TaskController::class);

Route::patch('/task/{task}/status', [TaskStatusController::class, 'update'])->name('task.status');

Route::view('/', 'welcome')->name('index');

require __DIR__.'/auth.php';
