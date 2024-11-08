<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\DayWorkController;
use App\Http\Controllers\PayOperationController;

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


Route::middleware('auth')
->group(function() {
    Route::get('/', IndexController::class)->name('home');
    Route::resource('site', SiteController::class);
    Route::resource('pay', PayController::class);

    Route::patch('/pay_msaa_check', [PayOperationController::class, 'pay_msaa_check'])->name('pay_msaa_check');

    Route::resource('day_work', DayWorkController::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout_do');
});

Route::controller(AuthController::class)
->middleware('guest')
->group(function() {
    Route::post('/login', 'login')->name('login_do');

});

Route::inertia('/login', 'Auth/Login')->name('login');


