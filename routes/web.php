<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\StatementController;



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

Route::get('/', function () {
    return view('welcome');
});


// Secured by auth routes
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');


    // Main application routes
    Route::get('/home', function () {return view('home');})->name('home');
    Route::get('/deposit', [DepositController::class, 'create'])->name('deposit');
    Route::post('/deposit', [DepositController::class, 'store']);

    Route::get('/withdraw', [WithdrawController::class, 'create'])->name('withdraw');
    Route::post('/withdraw', [WithdrawController::class, 'store']);


    Route::get('/transfer', [TransferController::class, 'create'])->name('transfer');
    Route::post('/transfer', [TransferController::class, 'store']);


    Route::get('/statement', [StatementController::class, 'view'])->name('statement');
});


Route::middleware('guest')->group(function () {


    // Auth routes
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    // Addtional pages
    Route::get('legal', function() {
        return view('legal');
    })->name('legal');

    
});