<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MrController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\FebricPartController;
use App\Http\Controllers\YarnBookingController;
use App\Http\Controllers\OrderManagementController;

Route::middleware('auth')->group(function () {
    Route::get('change/password', [UserController::class,'changePasswordForm'])->name('password.change');
    Route::post('change/password', [UserController::class,'changePassword'])->name('password.change');
    Route::controller(StockOutController::class)->group(function () {
        Route::get('/stock/out/stock-out-history/{style_id?}', 'stockOutHistory')->name('stock_out_history');
        Route::get('/stock/out/stock-out-info', 'stockOutInfo');
        Route::get('/stock/out/stock-out-history-info/{id}', 'stockOutHistoryInfo')->name('stock-out-history-info');
        Route::get('/stock/out/print-stockout-info/{id}', 'printStockOutInfo')->name('print-stockout-info');
        Route::get('/stock/out/download-stockout-info/{id}', 'downLoadStockOutInfo')->name('downLoadStockOutInfo');
        Route::get('/stock/out/encrypt', 'encrypt');

    });

    Route::controller(MrController::class)->group(function () {
            Route::post('get/inventory', 'get_inventory')->name('inventory.get');
            Route::get('boking-history/{id}', 'boking_histories')->name('boking_histories');
            Route::get('stock-history/{id}', 'stock_histories')->name('stock_histories');
            Route::get('stock-out-history/{id}', 'stock_out_histories')->name('stock_kout_histories');
            Route::get('booking-list/{id?}', 'booking_list')->name('inventory.list');
            Route::get('buyer-list', 'buyer_list')->name('buyer.list');
            Route::get('order-list/{orders?}', 'order_list')->name('order.list');
            Route::get('styles/{id?}', 'style_list')->name('style.index');

        });
    Route::controller(PdfController::class)->group(function () {
            Route::get('print/inventory/{style_id}', 'print_invenntory_report')->name('print.inventory');
            Route::get('download/inventory/{style_id}', 'download_invenntory_report')->name('download.inventory');
    });

    Route::get('seen-notification-alert', [StoreController::class,'seenNotificationAlert'])->name('seen_notification_alert');

    Route::get('orders-list',[OrderManagementController::class,'orders']);
    Route::get('order-management',[OrderManagementController::class,'index'])->name('order.management');
    Route::get('add-order',[OrderManagementController::class,'addOrder'])->name('add.order')->middleware(['roleCheck:SMR']);
    Route::post('order-create',[OrderManagementController::class,'createOrder']);
    Route::get('edit-order',[OrderManagementController::class,'editOrder']);
    Route::post('update-order',[OrderManagementController::class,'updateOrder']);
    Route::post('delete-order',[OrderManagementController::class,'deleteOrder']);
    Route::get('get-data',[OrderManagementController::class,'getData']);
    Route::get('print-order',[OrderManagementController::class,'printOrder'])->name('print.order');
    Route::get('download-order',[OrderManagementController::class,'downloadOrder'])->name('download.order');
    Route::get('download-shifted-order',[OrderManagementController::class,'downloadShiftedOrder'])->name('download.shifetdorder');
    Route::get('shit-order',[OrderManagementController::class,'shiftOrder'])->name('shit.order');
    Route::get('edit-shifted-order/{id}',[OrderManagementController::class,'editShiftOrder'])->name('edit.shifted.order');
    Route::post('update-shifted-order-status',[OrderManagementController::class,'updateShiftOrder'])->name('update-shifted-order-status');

    Route::get('print-booking-sheet/{id}',[YarnBookingController::class,'printBookingSheet'])->name('print_booking_sheet');
    Route::get('users', [UserController::class,'index'])->name('users');


});
