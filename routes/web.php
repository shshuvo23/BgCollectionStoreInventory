<?php

use App\Models\OrderManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MrController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\ViewCalenderController;

Auth::routes([
    'register' => false,
    'password.confirm' => false,
    'password.email' => false,
    'password.request' => false,
    'password.reset' => false,
    'password.update' => false,
]);

Route::get('test', [StoreController::class, 'getTableColumns'])->name('test');


Route::get('sing-in-github', [LoginController::class, 'github']);
Route::get('/sing-in/github/redirect', [LoginController::class, 'githubRedirect']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('get-notification', [NotificationController::class, 'showNotification']);
    Route::get('visit-notification', [NotificationController::class, 'visitNotification']);
    Route::get('/stock/out/get-style', [StyleController::class, 'index']);
    Route::middleware(['roleCheck:superAdmin'])
        ->prefix('super-admin')
        ->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'superAdminDashboard')->name('super_admin_dashboard');
                Route::get('users', 'index')->name('users');
                Route::get('user/create', 'create')->name('create_user');
                Route::post('store/user', 'store')->name('store_user');
                Route::get('user/role-create', 'roleCreate')->name('role_create');
                Route::post('user/role-store', 'roleStore')->name('role_store');
                Route::get('user/role-list', 'rolelist')->name('role_list');
                Route::get('edit-user/{id}', 'edit')->name('edit_user');
                Route::post('update/user/{id}', 'update')->name('update_user');
                Route::delete('delete/user/{id}', 'delete')->name('delete_user');
                Route::post('restore/user/{id}', 'restore')->name('restore_user');
                Route::get('trashed/users', 'trashedUser')->name('trashed_users');
                Route::post('user/parmanently/delete/{id}', 'parmanentlyDelete')->name('parmanentlyDelete');
            });
        });

    //Stock Out
    Route::group(['prefix' => 'stock/out', 'middleware' => 'roleCheck:StockOut'], function () {
        Route::controller(StockOutController::class)->group(function () {
            Route::get('create', 'stockOutCreate')->name('stockOutCreate');
            Route::get('get-data', 'getData');
            Route::get('get-accessories', 'getAccessories');
            Route::post('accessories-out', 'stockOut');
            Route::get('edit-stock-out-accessories/{id}', 'editStockOutAccessories')->name('edit_stock_out_accessories');
            Route::get('stock-out-edit-info/{id}', 'editStockOutInfo')->name('edit_stock_out_info');
            Route::post('update-edited-quantity/{stock_out_id}', 'updateEditedQty')->name('update_edited_quantity');
            Route::post('update-stockout-info-history/{id}', 'updateStockOutInfo')->name('update_stockout_info_history');
        });
    });

    Route::group(['middleware' => 'roleCheck:StockOut'], function () {
        Route::controller(ReceiverController::class)->group(function () {
            //Receiver
            Route::get('/receivers', 'index')->name('receivers');
            Route::get('get-receivers', 'getReceivers');
            Route::get('receiver/edit/{id}', 'edit');
            Route::post('receiver/update/{id}', 'update');
            Route::post('delete-receiver', 'deleteReceiver');
            Route::get('del-recv/{id}', [ReceiverController::class, 'delRecv']);
        });
    });

    Route::group(['prefix' => 'viewExportCalender', 'middleware' => 'roleCheck:viewExportCalender'], function () {
        Route::controller(ViewCalenderController::class)->group(function () {
            Route::get('/', 'exportCalenderDashboard')->name('viewerCalender_dashboard');
        });
    });

    // Route::group(['middleware' => 'roleCheck:StockOut'], function () {
    //     Route::controller(StyleController::class)->group(function () {
    //         //Style
    //         Route::get('get-style', 'index');

    //     });
    // });


    Route::middleware(['roleCheck:storeIn'])
        ->prefix('stock-in')
        ->group(function () {
            Route::controller(StoreController::class)->group(function () {
                // Route::get('/', 'stockInDashboard')->name('stock_in_dashboard');
                Route::get('/', 'mrrEntryForm')->name('stock_in_dashboard');

                Route::post('stock-in', 'stockIn')->name('stock_in');
                Route::get('get-single-unit', 'getSingleUnit')->name('get_single_unit');
                Route::get('stock-in-section', 'stockInSection')->name('stock_in_section');
                Route::get('mrr-list-view', 'mrrListView')->name('mrr_list_view');

                Route::get('mrr-list', 'mrrList')->name('mrr_list');
                // Route::get('order-list', 'orderList')->name('order_list');
                // Route::get('stock-in-form', 'mrrEntryForm')->name('stock_in_form');

                Route::get('order-list/{id}', 'viewInventory')->name('view_inventory');
                Route::get('mrr-view/{id}', 'mrrView')->name('mrr_view');
                Route::get('set-session', 'setSession')->name('set_session');
                Route::get('inventory-by-ajax', 'inventoryByAjax')->name('inventory_by_ajax');
                Route::get('mrr-view/{id}', 'mrrView')->name('mrr_view');
                Route::post('mrr-update/{id}', 'updateMrr')->name('mrr_update');
                Route::post('get_inventory', 'inventoryGet')->name('inventory_get');
            });
        });
});
