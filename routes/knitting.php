<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MrController;
use App\Http\Controllers\KnittingController;
use App\Http\Controllers\YarnBookingController;


Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'knitting', 'middleware' => 'roleCheck:knitting'], function () {
        Route::controller(KnittingController::class)
            ->group(function () {
                Route::get('/', 'knitting_dashboard')->name('knitting_dashboard');
                Route::get('view-booking/{id}', 'viewBooking')->name('view_booking');
            });
    });
});
