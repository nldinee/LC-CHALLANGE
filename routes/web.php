<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;

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
    Route::get('/home', function () {
        return view('welcome');
    });
});


Route::middleware('guest')->group(function () {


    // Auth routes
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    // Addtional pages
    Route::get('legal', function() {
        return 'Terms and conditions';
    })->name('legal');

    
});