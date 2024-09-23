<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetingController;



Route::middleware('auth')
->group(function() {
    Route::get('/settings/get', [SetingController::class,"get_all_settings"])->name('get_all_settings');
    Route::get('/settings/{name}', [SetingController::class,"get_settings"])->name('get_settings');
    Route::put('/settings/{seting}', [SetingController::class,"update_settings"])->name('update_settings');
    Route::post('/settings/{seting}', [SetingController::class,"create_settings"])->name('create_settings');
});
