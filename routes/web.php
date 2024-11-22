<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;

// ホームページをタスク一覧にリダイレクト
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// タスクのリソースルート
Route::resource('tasks', TaskController::class);

// 一括削除のルート
Route::post('tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulkDelete');

// タグのリソースルート
Route::resource('tags', TagController::class);
