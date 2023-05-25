<?php

use App\Models\User;
use App\Models\Buyer;
use App\Models\Order;
use App\Models\Style;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\NotificationStatus;
use App\Models\BookingHistory;
use App\Models\StockInHistory;
use App\Models\StockOutHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

function already_exists($table_name, $column_value)
{
    if (is_numeric($column_value)) {
        if (DB::table($table_name)->where('id', $column_value)->exists()) {
            return true;
        }
    }
}
function custom_decrypt($value)
{
    try {
        return Crypt::decrypt($value);
    } catch (DecryptException  $e) {
        abort(404);
    }
}
function get_user_name($id)
{
    $user = User::where('id', $id)->first('name');
    if ($user) {
        return $user->name;
    } else {
        return 'untracked';
    }
}
function get_buyer_name($id = null)
{
    $buyer = Buyer::where('id', $id)->first('buyer_name');
    if ($buyer) {
        return $buyer->buyer_name;
    }
}
function get_style_no($id = null)
{
    $style = Style::where('id', $id)->first('order_no');
    if ($style) {
        return $style->order_no;
    }
}

function get_inventory($inventory_id)
{
    $inventory_id = custom_decrypt($inventory_id);
    return Inventory::findOrFail($inventory_id);
}
function get_single_buyer_info($id)
{
    return Buyer::findOrFail(custom_decrypt($id));;
}
function get_single_order_info($id)
{
    return Order::findOrFail(custom_decrypt($id));;
}
function get_single_style_info($id)
{
    return Style::findOrFail(custom_decrypt($id));;
}
function get_inventories($style_id)
{
    return Inventory::join('styles', 'styles.id', '=', 'inventories.style_id')
        ->join('accessories', 'accessories.id', '=', 'inventories.accessories_id')
        ->join('units', 'units.id', '=', 'accessories.unit_id')
        ->leftjoin('colors', 'colors.id', '=', 'inventories.color_id')
        ->leftjoin('sizes', 'sizes.id', '=', 'inventories.size_id')
        ->select('inventories.id', 'styles.style_no', 'accessories.accessories_name', 'units.unit', 'colors.color_name', 'sizes.size', 'inventories.garments_quantity', 'inventories.requered_quantity', 'inventories.received_quantity', 'inventories.stock_quantity', 'inventories.consumption', 'inventories.bar_or_ean_code', 'inventories.tolerance','inventories.created_by')
        ->where('inventories.style_id', $style_id)
        ->orderBy('accessories.accessories_name', 'asc')
        ->get();
}

function get_booking_histories($inventory_id)
{
    $inventory_id = custom_decrypt($inventory_id);
    return BookingHistory::join('inventories', 'inventories.id', '=', 'booking_histories.inventory_id')
        ->join('accessories', 'accessories.id', '=', 'booking_histories.accessories_id')
        ->join('units', 'units.id', '=', 'accessories.unit_id')
        ->join('styles', 'styles.id', '=', 'inventories.style_id')
        ->leftjoin('colors', 'colors.id', '=', 'booking_histories.color_id')
        ->leftjoin('sizes', 'sizes.id', '=', 'booking_histories.size_id')
        ->where('inventories.id', $inventory_id)
        ->select('booking_histories.id', 'styles.style_no', 'accessories.accessories_name', 'units.unit', 'colors.color_name', 'sizes.size', 'booking_histories.garments_quantity', 'booking_histories.requered_quantity', 'booking_histories.created_at')
        ->get();
}

function get_stock_histories($inventory_id)
{

    $inventory = get_inventory($inventory_id);
    $style = $inventory->style_id;
    $accessory = $inventory->accessories_id;
    $color = $inventory->color_id;
    $size = $inventory->size_id;

    return StockInHistory::join('styles', 'styles.id', '=', 'stock_in_histories.style_id')
        ->join('accessories', 'accessories.id', '=', 'stock_in_histories.accessories_id')
        ->join('units', 'units.id', '=', 'accessories.unit_id')
        ->leftjoin('colors', 'colors.id', '=', 'stock_in_histories.color_id')
        ->leftjoin('sizes', 'sizes.id', '=', 'stock_in_histories.size_id')
        ->join('suppliers', 'suppliers.id', '=', 'stock_in_histories.supplier_id')
        ->join('challans', 'challans.id', '=', 'stock_in_histories.callan_id')
        ->where('stock_in_histories.style_id', $style)
        ->where('stock_in_histories.accessories_id', $accessory)
        ->where('stock_in_histories.color_id', $color)
        ->where('stock_in_histories.size_id', $size)
        ->select('stock_in_histories.id', 'styles.style_no', 'accessories.accessories_name', 'units.unit', 'colors.color_name', 'sizes.size', 'suppliers.supplier_name', 'challans.callan_no', 'stock_in_histories.mrr_no', 'stock_in_histories.collected_by', 'stock_in_histories.received_date', 'stock_in_histories.quantity')
        ->get();
}
function get_stock_Out_histories($inventory_id)
{
    $inventory = get_inventory($inventory_id);
    $style = $inventory->style_id;
    $accessory = $inventory->accessories_id;
    $color = $inventory->color_id;
    $size = $inventory->size_id;

    return  StockOutHistory::join('styles', 'styles.id', '=', 'stock_out_histories.style_id')
        ->join('accessories', 'accessories.id', '=', 'stock_out_histories.accessories_id')
        ->join('units', 'units.id', '=', 'accessories.unit_id')
        ->leftjoin('colors', 'colors.id', '=', 'stock_out_histories.color_id')
        ->leftjoin('sizes', 'sizes.id', '=', 'stock_out_histories.size_id')
        ->join('receivers', 'receivers.id', '=', 'stock_out_histories.receiver_id')
        ->where('stock_out_histories.style_id', $style)
        ->where('stock_out_histories.accessories_id', $accessory)
        ->where('stock_out_histories.color_id', $color)
        ->where('stock_out_histories.size_id', $size)
        ->select('stock_out_histories.id', 'styles.style_no', 'accessories.accessories_name', 'units.unit', 'colors.color_name', 'sizes.size', 'receivers.receiver_name', 'stock_out_histories.line_no', 'stock_out_histories.quantity', 'stock_out_histories.stock_out_date')
        ->get();
}
function total_accessories($style_id)
{
    return Inventory::where('style_id', $style_id)->count();
}


function get_style_status($status_no)
{
    switch ($status_no) {
        case 0: return 'Running'; break;
        case 1: return 'Completed'; break;
        case 2: return 'No Booking'; break;
    }
}

function showNotification()
{
    return Notification::join('styles', 'styles.id', '=', 'notifications.style_id')
        ->where('received_by', auth()->id())
        ->select('notifications.id', 'notifications.effected_accessories', 'notifications.style_id', 'notifications.message', 'notifications.created_at', 'notifications.updated_at', 'notifications.status', 'styles.style_no')
        ->orderBy('notifications.updated_at', 'desc')
        ->take(10)->get();
}


function unreadNotification()
{
    return Notification::where('received_by', auth()->id())->where('status', 0)->count();
}

function allNotification()
{
    return Notification::where('received_by', auth()->id())->count();
}


function notificationStatus($style_id, $notification_id)
{

    $notification_id =  Crypt::decrypt($notification_id);

    $notifications = Notification::where('style_id', $style_id)->where('received_by', auth()->id())->where('status', '0')->get();


    foreach ($notifications as $notification) {
        $notification->status = 1;
        $notification->timestamps = false;
        $notification->save();
    }
}

function submitBtn()
{
    return "<i class='fa fa-paper-plane'></i> Submit";
}
function updateBtn()
{
    return "<i class='fa fa-refresh'></i> Update";
}

function floatFormater($floatNumber){
    if(!is_numeric($floatNumber)){
        return $floatNumber;
    }
    $intNumber = (int)$floatNumber;
    if($floatNumber == $intNumber) return $intNumber;
    else return $floatNumber;
}

function notificationSeenStatus(){
    $notificationStatus = NotificationStatus::where('user_id', auth()->user()->id)->first();
    if($notificationStatus && $notificationStatus->status == 'on')return true;
    else return false;
}


