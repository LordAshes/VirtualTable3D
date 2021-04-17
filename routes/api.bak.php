<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthControllerController;
use App\Http\Controllers\TransactionController;

// ---------------
//  Public routes
// ---------------

// Register and login routes
// Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Logout route
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');	

	// Transaction related CRUD(S) routes
	Route::get('/transactions', [TransactionController::class, 'list'])->name('list');
	Route::post('/transactions', [TransactionController::class, 'create'])->name('create');
	Route::get('/transactions/{id}', [TransactionController::class, 'read'])->name('read');
	Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('update');
	Route::delete('/transactions/{id}', [TransactionController::class, 'delete'])->name('delete');
	Route::get('/transactions/since/{sequence}', [TransactionController::class, 'search'])->name('search');

// ------------------
//  Protected routes
// ------------------
Route::group(['middleware' => ['auth:sanctum']], function ()
{
});

// Note: General routing for all resource related routes to a controller... Route::resource('transactions', TransactionController::class);
