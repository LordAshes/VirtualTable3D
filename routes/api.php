<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransactionController;

// ---------------
//  Public routes
// ---------------

// Transaction related CRUD(S) routes
Route::get('/transactions', [TransactionController::class, 'list'])->name('list');
Route::post('/transactions', [TransactionController::class, 'create'])->name('create');
Route::get('/transactions/{id}', [TransactionController::class, 'read'])->name('read');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('update');
Route::delete('/transactions/{id}', [TransactionController::class, 'delete'])->name('delete');
Route::get('/transactions/{module}/except/{player}/since/{sequence}', [TransactionController::class, 'since'])->name('since');

// Note: General routing for all resource related routes to a controller... Route::resource('transactions', TransactionController::class);
