<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('welcome');})->name('welcome');
Route::post('users', UserController::class)->name('store-user');
Route::post('login', [AuthController::class,'store'])->name('login');
Route::post('logout', [AuthController::class,'destroy'])->name('logout');
Route::middleware(['auth'])->group(function(){
    Route::get('transaction', [TransactionController::class,'transactions'])->name('transactions');
    Route::get('deposit', [TransactionController::class,'deposits'])->name('deposits');
    Route::post('deposit', [TransactionController::class,'depositsStore'])->name('deposits.store');
    Route::get('withdrawal', [TransactionController::class,'withdrawals'])->name('withdrawals');
    Route::post('withdrawal', [TransactionController::class,'withdrawalStore'])->name('withdrawals.store');
});

