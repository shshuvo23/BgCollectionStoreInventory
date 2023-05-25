<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MrController;
use App\Http\Controllers\YarnBookingController;


Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'mr', 'middleware' => 'roleCheck:MR'], function () {
        Route::controller(MrController::class)
            ->group(function () {
                Route::get('/', 'mr_dashboard')->name('mr_dashboard');
                Route::get('create/style', 'create_style')->name('style.create');
                Route::post('store-style', 'store_style')->name('style.store');
                Route::get('get/style', 'get_style')->name('style.get');
                Route::post('get-orders', 'get_orders')->name('orders.get');
                Route::post('store/booking', 'store_booking')->name('booking.store');
                Route::post('get/unit', 'get_unit')->name('unit.get');
                Route::get('buyer/edit/{id}', 'buyer_edit')->name('buyer.edit');
                Route::put('buyer/update/{id}', 'buyer_update')->name('buyer.update');
                Route::get('order/edit/{id}', 'order_edit')->name('order.edit');
                Route::put('order/update/{id}', 'order_update')->name('order.update');
                Route::get('style/edit/{id}', 'style_edit')->name('style.edit');
                Route::put('style/update/{id}', 'style_update')->name('style.update');
                Route::get('style/update/status/{id}', 'update_style_status')->name('style_update.status');
                Route::get('booking/edit/{id}', 'edit_booking')->name('booking.edit');
                Route::put('booking/update/{id}', 'update_booking')->name('booking.update');

                // *********  For Yarn Booking  ************ //

                Route::get('order-list', 'oderList')->name('order_list_for_booking');
                Route::get('order-create', 'oderCreate')->name('order.create');
                Route::get('yarn-booking/{id}', 'yarnBooking')->name('yarn_booking');
                Route::get('get-yarn-booking-table', 'getYarnBookingTable')->name('get_yarn_booking_table');
                Route::get('change-fabrication', 'changeFabrication')->name('change_fabrication');
                Route::get('get-selected-fabric-item', 'getSelectedFabricItem')->name('get_selected_fabric_item');
                Route::get('set-unset-fabric', 'setUnsetFabric')->name('set_unset_fabric');
                Route::post('change-combo', 'changeCombo')->name('change_combo');
                Route::get('get-header-data', 'insertHeaderData')->name('insert_header_data');
            });

              //Yearn Booking
            //   Route::get('yearn-booking',[YarnBookingController::class,'create'])->name('create.booking');
              Route::get('new-yarn-order',[YarnBookingController::class,'newYarnOrder'])->name('new-yarn-order');
              Route::get('remarks',[YarnBookingController::class,'remarks'])->name('remarks');
              Route::post('update-remarks',[YarnBookingController::class,'updateRemarks'])->name('update.remarks');
              Route::post('store-yarn',[YarnBookingController::class,'storeYarn'])->name('store.yarn');

              Route::get('get-summery',[YarnBookingController::class,'getSummery'])->name('get_summery');
              Route::post('update-summery',[YarnBookingController::class,'updateSummery'])->name('update.summery');
              Route::get('send-booking',[YarnBookingController::class,'sendBooking'])->name('send_booking');



    });
});
