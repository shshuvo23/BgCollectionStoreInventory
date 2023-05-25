<?php

use App\Http\Controllers\ViewerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::controller(ViewerController::class)
        ->prefix('viewer')
        ->group(function () {
            Route::get('/', 'dashboard')->name('viewer_dashboard');
            Route::get('/view-booking/{id}', 'booking')->name('booking');
            Route::get('/knitting', 'knitting')->name('knitting');
        });
});
