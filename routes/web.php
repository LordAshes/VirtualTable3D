<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;

Route::get('/', [TableController::class, 'main'])->name('main');
Route::get('/resources/{folder}/{name}', [TableController::class, 'content'])->name('content');