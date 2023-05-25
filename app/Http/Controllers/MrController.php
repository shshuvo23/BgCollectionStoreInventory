<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Size;
use App\Models\Unit;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Color;
use App\Models\Combo;
use App\Models\Order;
use App\Models\Style;
use App\Models\Accessory;
use App\Models\Inventory;
use App\Models\Fabrication;
use App\Models\YarnBooking;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BookingHistory;
use App\Models\YarnAllocation;
use App\Models\NotificationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MrController extends Controller
{
    private function all_orders()
    {
        return  Order::orderBy('id', 'desc')->get();
    }
    private function all_styles()
    {
        return  Style::orderBy('id', 'desc')->get();
    }
    public function  mr_dashboard()
    {
        $styles = Style::leftjoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftjoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.order_id', '!=', null)
            ->select('styles.id', 'styles.style_no', 'styles.created_at', 'orders.order_no', 'buyers.buyer_name')
            ->orderBy('styles.id', 'desc')->get();
        return view('mr.dashboard', [
            'page_title' => 'Booking',
            'page_message' => 'Booking your accessories of a style',
            'styles' => $styles,
            'accessories' => Accessory::select('id', 'accessories_name')->get(),
            'colors' => Color::select('id', 'color_name')->get(),
            'sizes' => Size::select('id', 'size')->get(),
            'units' => Unit::select('id', 'unit')->get(),
        ]);
    }

    public function create_style()
    {
        return view('mr.create_style.create', [
            'isOrderCreate'=>0,
            'page_title' => 'Add new style',
            'page_message' => 'Create new Buyer, Order and Style',
            'buyers' => Buyer::all(),
        ]);
    }
    public function store_style(Request $request)
    {

        if($request->isOrderCreate==0){
            $request->validate([
                'buyer_name' => 'required|max:255',
                'order_no' => 'required|max:255',
                'style_no' => 'required|max:255',
            ]);
        }else{
             $request->validate([
                'buyer_name' => 'required|max:255',
                'order_no' => 'required|max:255',
            ]);
        }


        $buyer_name = $request->buyer_name;
        $order_no = $request->order_no;
        $style_no = $request->style_no;
        // Buyer entry
        if (is_numeric($buyer_name)) {
            if (!Buyer::where('id', $buyer_name)->exists()) {
                return back()->withErrors(['buyer_name' => "Number can't be a buyer name"]);
            }
        } else {
            $buyer_name =  Buyer::insertGetId([
                'buyer_name' => $buyer_name,
                'created_by' => auth()->id(),
                'created_at' => Carbon::now(),
            ]);
        }


        $order = Order::where('order_no', $order_no)->first();
        if(!$order){

            $order = new Order;
            $order->buyer_id = $buyer_name;
            $order->order_no = $order_no;
            $order->created_by = auth()->id();
            $order->created_at = Carbon::now();
            $order->save();

        }
       $order_no = $order->id;





        if($request->isOrderCreate==0){
              // style entry
        if (is_numeric($style_no)) {

            if (Style::where('id', $style_no)->exists()) {
                $style = Style::find($style_no);
                $style->order_id = $order_no;
                $style->updated_by = auth()->id();
                $style->save();
            } else {
                return back()->withErrors(['style_no' => "Number can't be a style number"]);
            }
        } else {
            Style::insertGetId([
                'order_id' => $order_no,
                'style_no' => $style_no,
                'created_by' => auth()->id(),
                'created_at' => Carbon::now(),
            ]);
        }
        }
        if($request->isOrderCreate==0){
            return back()->with('success', 'Style create successfully');
        }else{
            return back()->with('success', 'Order create successfully');

        }

    }

    public function get_orders(Request $request)
    {
        $buyer_id =  $request->buyer_id;
        if ($buyer_id) {
            $orders = Order::where('buyer_id', $buyer_id)->get(['id', 'order_no']);
            $total_order = $orders->count();
            if ($total_order) {
                $option =  "<option value='' selected> --Select One--</option>";
                foreach ($orders as  $order) {
                    $option .=  "<option value='$order->order_no'> $order->order_no </option>";
                }
                echo $option;
            } elseif ($total_order  == 0) {
                echo  $option =  "<option value='' selected> --Create New Order-- </option>";
            }
        } else {
            echo  $option =  "<option value='' selected> --Select Buyer First-- </option>";
        }
    }

    public function get_style(Request $request)
    {
        $styles = Style::where('order_id', null)->orderBy('id', 'desc')->get(['id', 'style_no']);
        $total_style = $styles->count();
        if ($total_style > 0) {
            $option =  "<option value='' selected> --Select One--</option>";
            foreach ($styles as  $style) {
                $option .=  "<option value='$style->id'> $style->style_no </option>";
            }
            echo $option;
        } else {
            echo  $option =  "<option value='' selected> --Enter New Style-- </option>";
        }
    }

    public function store_booking(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'style_no' => 'required',
            'accessories_name' => 'required',
            'unit' => 'required',
            'color' => 'nullable',
            'size' => 'nullable',
            'bar_or_ean_code' => 'nullable|max:255',
            'consumption' => 'required|numeric|max:25',
            'tolerance' => 'required|numeric|max:25',
            'garments_quantity' => 'required|numeric',
            'requered_quantity' => 'required|numeric',
            'accessories_photo' => 'nullable',
        ]);
        $current_time = Carbon::now();
        $auth_id = auth()->id();
        $style_no = $request->style_no;
        $accessories_name = $request->accessories_name;
        $unit = $request->unit;
        $color = $request->color;
        $size = $request->size;
        $bar_or_ean_code = $request->bar_or_ean_code;
        $consumption = $request->consumption;
        $tolerance = $request->tolerance;
        $garments_quantity = $request->garments_quantity;
        $requered_quantity = $request->requered_quantity;
        // $accessories_photo = $request->accessories_photo;

        $error_flag = 0;
        if ($validator->fails()) {
            $error_messages = $validator->errors()->messages();
            foreach ($error_messages as $key => $error) {
                $errors[$key] = $error;
            }
        }
        if ($accessories_name && is_numeric($accessories_name)) {
            if (!Accessory::where('id', $accessories_name)->exists()) {
                $error_flag = 1;
                $errors['accessories_name'] = "Accessories name can't be a Number";
            }
        }
        if ($unit && is_numeric($unit)) {
            if (!Unit::where('id', $unit)->exists()) {
                $error_flag = 1;
                $errors['unit'] = "unit can't be a Number";
            }
        }
        if ($color && is_numeric($color)) {
            if (!Color::where('id', $color)->exists()) {
                $error_flag = 1;
                $errors['color'] = "Color can't be a Number";
            }
        }
        if ($size && is_numeric($size)) {
            if (!Size::where('id', $size)->exists()) {
                $error_flag = 1;
                $errors['size'] = "size can't be a Number";
            }
        }
        if ($error_flag || $validator->fails()) {
            return response()->json($errors);
        }
        // insert into unit
        if ($unit && !is_numeric($unit)) {
            $u = Unit::where('unit', $unit);
            if ($u->exists()) {
                $unit = $u->first()->id;
            } else {
                $unit =  Unit::insertGetId([
                    'unit' =>  $unit,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // insert into accessories
        if ($accessories_name && !is_numeric($accessories_name)) {
            $ac = Accessory::where('accessories_name', $accessories_name);
            if ($ac->exists()) {
                $accessories_name = $ac->first()->id;
            } else {
                $accessories_name =  Accessory::insertGetId([
                    'unit_id' =>  $unit,
                    'accessories_name' =>  $accessories_name,
                    'accessories_photo' => null,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // insert into Color
        if ($color && !is_numeric($color)) {
            $c = Color::where('color_name', $color);
            if ($c->exists()) {
                $color = $c->first()->id;
            } else {
                $color =  Color::insertGetId([
                    'color_name' =>  $color,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // insert into size
        if ($size && !is_numeric($size)) {
            $s =  Size::where('size', $size);
            if ($s->exists()) {
                $size = $s->first()->id;
            } else {
                $size =  Size::insertGetId([
                    'size' =>  $size,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // echeck enventory exist or not

        if (Inventory::where(['style_id' => $style_no, 'accessories_id' => $accessories_name, 'color_id' => $color, 'size_id' => $size])->exists()) {
            $errors['error'] = "Already have a Booking";
            return response()->json($errors);
        }



        $inventory = Inventory::insertGetId([
            'style_id' =>  $style_no,
            'accessories_id' =>  $accessories_name,
            'color_id' =>  $color,
            'size_id' =>  $size,
            'bar_or_ean_code' =>  $bar_or_ean_code,
            'consumption' =>  $consumption,
            'tolerance' =>  $tolerance,
            'garments_quantity' =>  $garments_quantity,
            'requered_quantity' =>  $requered_quantity,
            'consumption' =>  $consumption,
            'created_by' => $auth_id,
            'created_at' => $current_time,
        ]);
        // insert into booking

        $booking_id =  BookingHistory::insertGetId([
            'inventory_id' =>   $inventory,
            'accessories_id' =>  $accessories_name,
            'color_id' =>  $color,
            'size_id' =>  $size,
            'bar_or_ean_code' =>  $bar_or_ean_code,
            'consumption' =>  $consumption,
            'tolerance' =>  $tolerance,
            'garments_quantity' =>  $garments_quantity,
            'requered_quantity' =>  $requered_quantity,
            'created_by' => $auth_id,
            'created_at' => $current_time,
        ]);

        $this->booking_accessory_notification($style_no, $inventory, $type = 0);
        return response()->json(['success' => 'Booking Success']);
    }

    public function get_unit(Request $request)
    {
        $id = $request->id;
        $accessory = Accessory::select('unit_id')->where('id', $id)->first();
        if ($accessory) {
            echo  $unit_id = $accessory->unit_id;
        } else {
            echo false;
        }
    }
    public function get_inventory(Request $request)
    {

        $style_id = $request->style_id;
        if (!is_numeric($style_id)) {
            return '<h2 class="text-center text-danger mt-3"> No Inventory</h2>';
        }
        $style = Style::findOrFail($style_id);
        $inventories = get_inventories($style_id);
        $style = Style::findOrFail($style_id);

        return view('mr.style_wise_booking', [
            'inventories' => $inventories,
            'style' => $style,
        ]);
    }
    public function edit_booking($inventory_id)
    {
        $inventory_id = custom_decrypt($inventory_id);
        $inventory = Inventory::join('booking_histories', 'inventories.id', '=', 'booking_histories.inventory_id')
            ->where('inventories.id', $inventory_id)
            ->select(['inventories.id', 'inventories.style_id', 'inventories.accessories_id', 'inventories.color_id', 'inventories.size_id', 'inventories.garments_quantity', 'inventories.requered_quantity', 'booking_histories.consumption', 'booking_histories.bar_or_ean_code', 'booking_histories.tolerance'])
            ->orderBy('booking_histories.created_at', 'desc')
            ->first();
        return view('mr.edit-booking', [
            'page_title' => 'Update Booking',
            'page_message' => 'Update Accessories Booking - Store Management Application',
            'styles' => Style::select('id', 'style_no')->where('order_id', '!=', null)->orderBy('id', 'desc')->get(),
            'accessories' => Accessory::select('id', 'accessories_name')->get(),
            'colors' => Color::select('id', 'color_name')->get(),
            'sizes' => Size::select('id', 'size')->get(),
            'units' => Unit::select('id', 'unit')->get(),
            'inventory' => $inventory,
            'url' => route('booking.update', $inventory->id),
        ]);
    }
    public function update_booking(Request $request, $inventory_id)
    {
        $validator = Validator::make($request->all(), [
            'style_no' => 'required',
            'accessories_name' => 'required',
            'unit' => 'required',
            'color' => 'nullable',
            'size' => 'nullable',
            'bar_or_ean_code' => 'nullable|max:255',
            'consumption' => 'required|numeric|max:25',
            'tolerance' => 'required|numeric|max:25',
            'garments_quantity' => 'required|numeric',
            'requered_quantity' => 'required|numeric',
            'accessories_photo' => 'nullable',
        ]);
        $current_time = Carbon::now();
        $auth_id = auth()->id();
        $style_no = $request->style_no;
        $accessories_name = $request->accessories_name;
        $unit = $request->unit;
        $color = $request->color;
        $size = $request->size;
        $bar_or_ean_code = $request->bar_or_ean_code;
        $consumption = $request->consumption;
        $tolerance = $request->tolerance;
        $garments_quantity = $request->garments_quantity;
        $requered_quantity = $request->requered_quantity;
        // $accessories_photo = $request->accessories_photo;
        $errors = [];
        if ($validator->fails()) {
            $error_messages = $validator->errors()->messages();
            foreach ($error_messages as $key => $error) {
                $errors[$key] = $error;
            }
        }

        if ($accessories_name && is_numeric($accessories_name)) {
            if (!Accessory::where('id', $accessories_name)->exists()) {
                $errors['accessories_name'] =  "Accessories name can't be a Number";
            }
        }
        if ($unit && is_numeric($unit)) {
            if (!Unit::where('id', $unit)->exists()) {
                $errors['unit'] =  "unit can't be a Number";
            }
        }
        if ($color && is_numeric($color)) {
            if (!Color::where('id', $color)->exists()) {
                $errors['color'] =  "Color can't be a Number";
            }
        }
        if ($size && is_numeric($size)) {
            if (!Size::where('id', $size)->exists()) {
                $errors['size'] =  "size can't be a Number";
            }
        }
        if (count($errors)) {
            return back()->withErrors($errors);
        }
        // insert into unit
        if ($unit && !is_numeric($unit)) {
            $u = Unit::where('unit', $unit);
            if ($u->exists()) {
                $unit = $u->first()->id;
            } else {
                $unit =  Unit::insertGetId([
                    'unit' =>  $unit,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // insert into accessories
        if ($accessories_name && !is_numeric($accessories_name)) {
            $ac = Accessory::where('accessories_name', $accessories_name);
            if ($ac->exists()) {
                $accessories_name = $ac->first()->id;
            } else {
                $accessories_name =  Accessory::insertGetId([
                    'unit_id' =>  $unit,
                    'accessories_name' =>  $accessories_name,
                    'accessories_photo' => null,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // insert into Color
        if ($color && !is_numeric($color)) {
            $c = Color::where('color_name', $color);
            if ($c->exists()) {
                $color = $c->first()->id;
            } else {
                $color =  Color::insertGetId([
                    'color_name' =>  $color,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // insert into size
        if ($size && !is_numeric($size)) {
            $s =  Size::where('size', $size);
            if ($s->exists()) {
                $size = $s->first()->id;
            } else {
                $size =  Size::insertGetId([
                    'size' =>  $size,
                    'created_by' => $auth_id,
                    'created_at' => $current_time,
                ]);
            }
        }
        // echeck enventory exist or not

        $inventory = Inventory::where('id', $inventory_id)->first();
        $inventory->style_id = $style_no;
        $inventory->accessories_id = $accessories_name;
        $inventory->color_id = $color;
        $inventory->size_id = $size;
        $inventory->bar_or_ean_code = $bar_or_ean_code;
        $inventory->consumption = $consumption;
        $inventory->tolerance = $tolerance;
        $inventory->garments_quantity = $garments_quantity;
        $inventory->requered_quantity = $requered_quantity;
        $inventory->updated_by =  $auth_id;
        $inventory->save();

        $inventory = $inventory->id;

        // insert into booking

        BookingHistory::insert([
            'inventory_id' =>   $inventory,
            'accessories_id' =>  $accessories_name,
            'color_id' =>  $color,
            'size_id' =>  $size,
            'bar_or_ean_code' =>  $bar_or_ean_code,
            'consumption' =>  $consumption,
            'tolerance' =>  $tolerance,
            'garments_quantity' =>  $garments_quantity,
            'requered_quantity' =>  $requered_quantity,
            'created_by' => $auth_id,
            'created_at' => $current_time,
        ]);
        $this->booking_accessory_notification($style_no, $inventory, $type = 1);
        return back()->with(['success' => 'Booking updated successfully']);
    }
    public function boking_histories($inventory_id)
    {
        return view('mr.booking_histories', [
            'page_title' => 'Booking Histories',
            'page_message' => 'Booking Historiy list  of BG Collection App',
            'booking_histories' =>   get_booking_histories($inventory_id),
        ]);
    }
    public function stock_histories($inventory_id)
    {
        $stock_in_histories = get_stock_histories($inventory_id);
        return view('mr.stock_histories', [
            'page_title' => 'Stock Histories',
            'page_message' => 'Stock Historiy list  of BG Collection App',
            'stock_in_histories' => $stock_in_histories
        ]);
    }
    public function stock_out_histories($inventory_id)
    {
        $stock_out_histories = get_stock_Out_histories($inventory_id);
        return view('mr.stock_out_histories', [
            'page_title' => 'Stockout Histories',
            'page_message' => 'Stockout Historiy list  of BG Collection App',
            'stock_out_histories' => $stock_out_histories
        ]);
    }
    public function booking_list(Request $request, $style_id = null)
    {
        $notification = false;
        $effected_inventory_ids = [];
        if ($style_id) {
            $style_id =  custom_decrypt($style_id);
            $inventories = get_inventories($style_id);
        } else {
            $inventories = false;
        }
        // update notification
        $notification_id =  $request->n_id;
        if ($notification_id) {
            notificationStatus($style_id, $notification_id);
            if ($style_id) {
                $notification =  Notification::find(custom_decrypt($request->n_id));
                $effected_inventory_ids = explode(',', $notification->effected_inventory_ids);
            }
        }
        $styles = Style::leftjoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftjoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.order_id', '!=', null)
            ->select('styles.id', 'styles.style_no', 'styles.created_at', 'orders.order_no', 'buyers.buyer_name')
            ->orderBy('styles.id', 'desc')->get();
        // return  $inventories;
        return view('mr.search_booking', [
            'page_title' => 'Inventories',
            'page_message' => 'The inventory list  of BG Collection App',
            'styles' => $styles,
            'inventories' => $inventories,
            'style_id' => $style_id,
            'notification' => $notification,
            'effected_inventory_ids' => $effected_inventory_ids,
        ]);
    }
    public function buyer_list()
    {
        $buyers = Buyer::orderBy('id', 'desc')->get();

        return view('mr.buyers', [
            'page_title' => 'Buyers',
            'page_message' => 'All buyer list  of BG Collection App',
            'buyers' => $buyers
        ]);
    }

    function buyer_edit($id)
    {
        $buyer =   get_single_buyer_info($id);
        $page_title = 'Buyer Edit';
        $page_message = 'Update Buyer Name of BG Collection App';
        return view('mr.buyer.edit_buyer', compact('buyer', 'page_title', 'page_message'));
    }
    function buyer_update(Request $request, $id)
    {
        $request->validate([
            'buyer_name' => 'required|max:255',
            // |unique:buyers,buyer_name,except,' . custom_decrypt($id)
        ]);
        $buyer = get_single_buyer_info($id);
        $buyer->buyer_name = $request->buyer_name;
        $buyer->updated_by = auth()->id();
        $buyer->save();
        return  redirect()->route('buyer.list')->with('success', 'Updated successfully');
    }
    public function order_list(Request $request, $buyer_id = null)
    {

        if ($buyer_id) {
            $buyer_id = custom_decrypt($buyer_id);
            $order = Order::where('buyer_id',  $buyer_id);
            if ($order->exists()) {
                $orders = $order->get();
            }
        }
        if (!isset($orders)) {
            $orders = $this->all_orders();
        }
        return view('mr.orders', [
            'page_title' => 'Orders',
            'page_message' => 'All order list of BG Collection App',
            'orders' => $orders,
            'buyer_id' => $buyer_id,
        ]);
    }
    function order_edit($id)
    {
        $order =   get_single_order_info($id);
        $buyers = Buyer::all(['id', 'buyer_name']);
        $page_title = 'Order Edit';
        $page_message = 'Update Order No of BG Collection App';
        return view('mr.order.edit', compact('order', 'buyers', 'page_title', 'page_message'));
    }
    function order_update(Request $request, $id)
    {
        $request->validate([
            'buyer_name' => 'required|max:255',
            'order_no' => 'required|max:255'
        ]);
        $order = get_single_order_info($id);
        $order->buyer_id = $request->buyer_name;
        $order->order_no = $request->order_no;
        $order->updated_by = auth()->id();
        $order->save();
        return  redirect()->route('order.list')->with('success', 'Updated successfully');
    }

    // style
    public function style_list($order_id = null)
    {
        if ($order_id) {
            $order_id = custom_decrypt($order_id);
            $styles = Style::where('order_id',  $order_id)->orderBy('id', 'desc');
            if ($styles->exists()) {
                $styles = $styles->get();
            }
        }
        if (!isset($styles)) {
            $styles = $this->all_styles();
        }
        return view('mr.style.index', [
            'page_title' => 'Styles',
            'page_message' => 'All style list  of BG Collection App',
            'styles' => $styles,
            'order_id' => $order_id,
        ]);
    }
    function style_edit($id)
    {
        $style =   get_single_style_info($id);
        $orders = Order::all(['id', 'order_no']);
        $page_title = 'Style Edit';
        $page_message = 'Update style of BG Collection App';
        return view('mr.style.edit', compact('style', 'orders', 'page_title', 'page_message'));
    }
    function style_update(Request $request, $id)
    {
        $request->validate([
            'order_no' => 'required|max:255',
            'style_no' => 'required|max:255'
        ]);
        $style = get_single_style_info($id);
        $style->order_id = $request->order_no;
        $style->style_no = $request->style_no;
        $style->updated_by = auth()->id();
        $style->save();
        return  redirect()->route('style.index')->with('success', 'Updated successfully');
    }
    function update_style_status($id)
    {
        // return $id = custom_decrypt($id);
        $style = get_single_style_info($id);
        if ($style->status == 1) {
            $style->status = 0;
        } else {
            $style->status = 1;
        }
        $style->updated_by = auth()->id();
        $style->save();
        return  redirect()->route('style.index')->with('success', 'Status updated successfully');
    }

    private function booking_accessory_notification($style_no, $inventory_id = null, $type = 0)
    {
        $store_users = DB::table('users')->where('role_id', 3)->get('id');
        $user_id = [];
        foreach ($store_users as $store_user) {
            array_push($user_id, $store_user->id);
        }
        $notifications = Notification::where('style_id', $style_no)->where('type', $type)->whereDate('created_at', Carbon::today())->whereIn('received_by', $user_id)->get();
        if ($notifications->count()) {
            foreach ($notifications as  $notification) {
                if ($notification->effected_inventory_ids == '') {
                    $notification->effected_inventory_ids  .= $inventory_id;
                } else {
                    $notification->effected_inventory_ids  .= ",$inventory_id";
                }
                $notification->effected_accessories += 1;
                $notification->status = 0;
                $notification->updated_by = auth()->id();
                $notification->save();
                $this->notificationStatus($notification->received_by);
            }
        } else {
            if ($type == 0) {
                $message = 'new accessories booking found for style';
            } else {
                $message = 'accessories updated by ' . auth()->user()->name;
            }
            foreach ($store_users  as $store_user) {
                $notification = new Notification;
                $notification->style_id = $style_no;
                $notification->message = $message;
                $notification->effected_accessories = 1;
                $notification->effected_inventory_ids = $inventory_id;
                $notification->type = $type;
                $notification->received_by = $store_user->id;
                $notification->created_by = auth()->id();
                $notification->save();
                $this->notificationStatus($notification->received_by);
            }
        }
    }
    private function notificationStatus($mr_id){
        $notificationStatus = NotificationStatus::where('user_id', $mr_id)->first();
        if($notificationStatus){
            $notificationStatus->status = 'on';
            $notificationStatus->update();
        }else{
            $notificationStatus = new NotificationStatus;
            $notificationStatus->user_id = $mr_id;
            $notificationStatus->status = 'on';
            $notificationStatus->save();
        }
    }







    //********** YARN **************//

    public function oderList(){
        $orders = Order::join('buyers', 'buyers.id', '=', 'orders.buyer_id')
                        ->select('orders.id', 'orders.order_no', 'buyers.buyer_name')
                        ->get();

        return view('mr.yarn.orderList', compact('orders'));
    }

    public function yarnBooking($orderId){
        Order::findOrFail($orderId);
        $yarnBooking = YarnBooking::where('order_id', $orderId)->first();
        if(!$yarnBooking){
            $yarnBooking = new YarnBooking;
            $yarnBooking->order_id = $orderId;
            $yarnBooking->created_by = auth()->user()->id;
            $yarnBooking->save();
        }

        return view('mr.yarn.yarnBooking',compact('orderId','yarnBooking'));
    }

    private function add_fabrication($id){
        $fabricationsObj = new Fabrication;
        $fabricationsObj->order_id = $id;
        $fabricationsObj->created_by = auth()->id();
        $fabricationsObj->cos_dzn = 0;
        $fabricationsObj->process_loss = 0;
        $fabricationsObj->save();
        return $fabricationsObj;
    }

    private function add_combo($id){
        $combosObj = new Combo;
        $combosObj->order_id = $id;
        $combosObj->qty = 0;
        $combosObj->extra_cutting = 0;
        $combosObj->new_qty=0;
        $combosObj->total_finished = 0;
        $combosObj->total_gray = 0;
        $combosObj->created_by = auth()->id();
        $combosObj->save();
        return $combosObj;
    }

    public function getYarnBookingTable(Request $request){
        $id = $request->id;
        // $id = 1;
        if($request->row){$this->add_combo($id);}
        if($request->col){$this->add_fabrication($id);}
        //yearn booking data
        $yarnBooking= YarnBooking::where('order_id',$id)->first();



        $fabrications = Fabrication::where('order_id', $id)->get();
        if(!count($fabrications)){
            $fabrications = [$this->add_fabrication($id)];
        }
        $combos = Combo::where('order_id', $id)->get();
        if(!count($combos)){
            $combos = [$this->add_combo($id)];
        }
        foreach($combos as $key => $combo){
            $yarnAllocations = YarnAllocation::where('combo_id', $combo->id)->where('status', 1)->get();
            $combos[$key]['yarnAllocations'] = $yarnAllocations->toArray();
        }
        $orderInfo = Order::join('buyers','buyers.id','=','orders.buyer_id')
        ->leftjoin('styles','styles.order_id','=','orders.id')
        ->select('orders.order_no','buyers.buyer_name','styles.style_no')
        ->where('orders.id', $id)
        ->first();
        $orderId = $id;
       return view('mr.yarn.yarnBookingTable')->with(compact('fabrications','combos','yarnBooking','orderId','orderInfo'));
        // return view('pdf.yarnBookinSheet')->with(compact('fabrications','combos','yarnBooking','orderId','orderInfo'));
    }

    protected function changeFabrication(Request $request){
        $changeFabricForAndDzn = null;
        $fabrication = Fabrication::findOrFail($request->id);

        if($fabrication->process_loss != $request->pcsLoss || $fabrication->cos_dzn != $request->dzn){
            $changeFabricForAndDzn = true;
        }
        $fabrication->fabrication = $request->fabric;
        $fabrication->item = $request->item;
        $fabrication->fabric_for = $request->fabricFor;
        $fabrication->cos_dzn = $request->dzn;
        $fabrication->gsm = $request->gsm;
        $fabrication->dia = $request->dia;
        $fabrication->yarn_count = $request->count;
        $fabrication->process_loss = $request->pcsLoss;
        $fabrication->updated_by = auth()->id();
        $fabrication->update();
        // return  $fabrication
        $combos = [];
        if($changeFabricForAndDzn){
            $combos = $this->resetYarnBookingAfterChangingFabrication($fabrication);
        }
        return $combos;
    }

    protected function getSelectedFabricItem(Request $request){
        $id = $request->id;
        $yarnAllocations = YarnAllocation::where('combo_id', $id)->where('status', 1);
        $values = $yarnAllocations->select('req_finished','req_gray', 'fabric_id')->get();
        $ids = $yarnAllocations->pluck('fabric_id')->toArray();
        return [$values, $ids];
    }

    protected function setUnsetFabric(Request $request){
        $comboId = $request->comboId;
        $fabricId = $request->fabricId;
        $status = $request->status;
        $status = $status == 'true' ? true: false;

        $combo = Combo::findOrFail($comboId);
        $fabrication = Fabrication::findOrFail($fabricId);
        $yarnAllocation = YarnAllocation::where('combo_id', $comboId)->where('fabric_id',$fabricId)->first();

        if(!$yarnAllocation){
            $yarnAllocation = new YarnAllocation;
            $yarnAllocation->combo_id = $comboId;
            $yarnAllocation->fabric_id = $fabricId;
            $yarnAllocation->created_by = auth()->id();
            $yarnAllocation->save();
        }

        if($status){
            $rf = ceil((($combo->new_qty / 12)) * $fabrication->cos_dzn);
            $rg = ceil($rf / ((100-$fabrication->process_loss)/100));

            $yarnAllocation->req_finished = $rf;
            $yarnAllocation->req_gray = $rg;
            $yarnAllocation->status = true;
            $yarnAllocation->updated_by = auth()->id();
            $yarnAllocation->update();

            $combo->total_finished += $rf;
            $combo->total_gray += $rg;
            $combo->updated_by = auth()->id();
            $combo->update();

            $fabrication->total_finished += $rf;
            $fabrication->total_gray += $rg;
            $fabrication->updated_by = auth()->id();
            $fabrication->update();



        }else{
            $rf = $yarnAllocation->req_finished;
            $rg = $yarnAllocation->req_gray;

            $yarnAllocation->status = false;
            $yarnAllocation->updated_by = auth()->id();
            $yarnAllocation->update();

            $combo->total_finished -= $rf;
            $combo->total_gray -= $rg;
            $combo->updated_by = auth()->id();
            $combo->update();

            $fabrication->total_finished -= $rf;
            $fabrication->total_gray -= $rg;
            $fabrication->updated_by = auth()->id();
            $fabrication->update();
        }

    }

    protected function changeCombo(Request $request){
        $orderId = $request->orderId;
        $comboId = $request->comboId;
        $changedColumn = $request->changedColumn;
        $comboRow = $request->comboRow;
        $totalFinished = 0;
        $totalGray = 0;
        if($changedColumn == 'qty'||$changedColumn == 'extra_cutting'|| $changedColumn == 'new_qty'){
            if($changedColumn == 'qty'||$changedColumn == 'extra_cutting'){
                $comboRow[6] = ceil($comboRow[4] + ($comboRow[4] * ($comboRow[5]/100)));
            }
            if(count($comboRow)>10){
                for($i=0; $i<count($comboRow[10]); $i++){
                    $fabrication = Fabrication::findOrFail($comboRow[10][$i][0]);

                    $rf = ceil((($comboRow[6] / 12) * $fabrication->cos_dzn));
                    $rg = ceil($rf / ((100-$fabrication->process_loss)/100));
                    $yarnAllocation = YarnAllocation::where('combo_id', $comboId)->where('fabric_id',$fabrication->id)->first();
                    if($yarnAllocation){
                        $fabrication->total_finished = ($fabrication->total_finished - $yarnAllocation->req_finished + $rf);
                        $fabrication->total_gray = ($fabrication->total_gray - $yarnAllocation->req_gray + $rg);
                        $fabrication->updated_by = auth()->id();
                        $fabrication->update();

                        $yarnAllocation->req_finished = $rf;
                        $yarnAllocation->req_gray = $rg;
                        $yarnAllocation->updated_by = auth()->id();
                        $yarnAllocation->update();
                        $totalFinished += $rf;
                        $totalGray += $rg;
                        // return $totalFinished;
                    }

                }
            }
        }
        if(($changedColumn == 'rf' || $changedColumn == 'rg')&& count($comboRow)>10){
            for($i=0; $i<count($comboRow[10]); $i++){
                $yarnAllocation = YarnAllocation::where('combo_id', $comboId)->where('fabric_id',$comboRow[10][$i][0])->first();
                $fabrication = Fabrication::find($comboRow[10][$i][0]);

                if($yarnAllocation){
                    $fabrication->total_finished = ($fabrication->total_finished - $yarnAllocation->req_finished + $comboRow[10][$i][1]);
                    $fabrication->total_gray = ($fabrication->total_gray - $yarnAllocation->req_gray + $comboRow[10][$i][2]);
                    $fabrication->updated_by = auth()->id();
                    $fabrication->update();

                    $yarnAllocation->req_finished = $comboRow[10][$i][1];
                    $yarnAllocation->req_gray = $comboRow[10][$i][2];
                    $yarnAllocation->updated_by = auth()->id();
                    $yarnAllocation->update();
                    $totalFinished += $comboRow[10][$i][1];
                    $totalGray += $comboRow[10][$i][2];
                }
            }
        }

        $combo = Combo::findOrFail($comboId);
        $combo->combo = $comboRow[0];
        $combo->color = $comboRow[1];
        $combo->ld_no = $comboRow[2];
        $combo->shade = $comboRow[3];
        $combo->qty = $comboRow[4];
        $combo->extra_cutting  = $comboRow[5];
        $combo->new_qty = $comboRow[6];
        $combo->total_finished = $comboRow[7];
        $combo->total_gray = $comboRow[8];
        $combo->remarks = $comboRow[9];
        $combo->updated_by = auth()->id();
        if($changedColumn == 'qty' || $changedColumn == 'extra_cutting' || $changedColumn == 'new_qty' || $changedColumn == 'rf' || $changedColumn == 'rg'){
            $combo->total_finished = $totalFinished;
            $combo->total_gray = $totalGray;
        }
        $combo->update();
    }

    protected function resetYarnBookingAfterChangingFabrication($fabrication){
        $yarnAllocations = YarnAllocation::where('fabric_id', $fabrication->id)->get();
        $combos = [];
        foreach($yarnAllocations as $yarnAllocation){
            $combo = Combo::findOrFail($yarnAllocation->combo_id);
            $rf = ceil((($combo->new_qty / 12)) * $fabrication->cos_dzn);
            $rg = ceil($rf/((100-$fabrication->process_loss)/100));

            if($yarnAllocation->status){
                $combo->total_finished -= $yarnAllocation->req_finished;
                $combo->total_finished += $rf;
                $combo->total_gray -= $yarnAllocation->req_gray;
                $combo->total_gray += $rg;
                $combo->updated_by = auth()->id();
                $combo->update();

                $fabrication->total_finished -= $yarnAllocation->req_finished;
                $fabrication->total_finished += $rf;
                $fabrication->total_gray -= $yarnAllocation->req_gray;
                $fabrication->total_gray += $rg;
                $fabrication->updated_by = auth()->id();
                $fabrication->update();
                array_push($combos, $combo->id);
            }

            $yarnAllocation->req_finished = $rf;
            $yarnAllocation->req_gray = $rg;
            $yarnAllocation->updated_by = auth()->id();
            $yarnAllocation->update();
        }
        return $combos;
    }

    public function oderCreate(){
        return view('mr.create_style.create', [
            'isOrderCreate'=>1,
            'page_title' => 'Add new order',
            'page_message' => 'Create new Buyer and Order',
            'buyers' => Buyer::all(),
        ]);
    }

    public function insertHeaderData(Request $request){
        $orderId = $request->OrderId;
        $yarnBooking= YarnBooking::where('order_id',$orderId)->first();

        if(!$yarnBooking){
            $yarnBooking = new YarnBooking;
            $yarnBooking->created_by = auth()->user()->id;
            $yarnBooking->order_id = $orderId;
            $yarnBooking->revised = $request->revised;
            $yarnBooking->hrader_text = $request->hrader_text;
            $yarnBooking->save();
            }
        else{
            $yarnBooking->updated_by = auth()->user()->id;
            $yarnBooking->revised = $request->revised;
            $yarnBooking->hrader_text = $request->hrader_text;
            $yarnBooking->update();
        }

        }
}
