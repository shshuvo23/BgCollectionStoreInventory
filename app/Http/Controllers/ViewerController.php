<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Order;
use App\Models\Style;
use App\Models\YarnBooking;
use App\Models\YarnAllocation;
use App\Models\Fabrication;
use App\Models\Combo;
use Illuminate\Http\Request;

class ViewerController extends Controller
{
    public function dashboard()
    {

        $total_buyer = Buyer::count();
        $total_order = Order::count();
        $total_style = Style::count();
        $total_running_style = Style::where('status', 0)->count();
        $total_completed_style = Style::where('status', 1)->count();
        $page_title = 'Dashboard';
        $page_message = 'Store Management Application';
        return view('viewers.dashboard', compact(['page_title', 'page_message', 'total_buyer', 'total_order', 'total_style', 'total_running_style', 'total_completed_style']));
    }

    public function knitting()
    {

        $orders = Order::join('yarn_bookings', 'orders.id', '=', 'yarn_bookings.order_id')
            ->join('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('yarn_bookings.status', 'booked')
            ->select('orders.id', 'orders.order_no', 'buyers.buyer_name')
            ->get();

        return view('viewers.yarnBooking', [
            'page_title' => 'Booking',
            'page_message' => 'Booking your accessories of a style',
            'orders' => $orders,
        ]);
    }

    public function booking($id)
    {
        Order::findOrFail($id);
        $yarnBooking = YarnBooking::where('order_id', $id)->first();
        // return gettype($yarnBooking);
        $summery = '';
        $remark = '';
        if ($yarnBooking) {
            // $revised = $yarnBooking->
            $remark = $yarnBooking->remarks;
            $summery = $yarnBooking->summery;
        }
        $remarks = explode("勘", $remark);
        if ($remark == '' || $remark == null || $remarks == null) {
            $remarks = [];
        }



        if ($summery == null) {
            $summeries = [];
        } else $summeries = explode("勘", $summery);
        if ($summeries == '' || $summeries == null || $summeries == null) {
            $summeries = [];
        }
        for ($i = 0; $i < count($summeries); $i++) {
            $summeries[$i] = explode("௱", $summeries[$i]);
        }



        $fabrications = Fabrication::where('order_id', $id)->get();
        if (!count($fabrications)) {
            $fabrications = [$this->add_fabrication($id)];
        }
        $combos = Combo::where('order_id', $id)->get();
        if (!count($combos)) {
            $combos = [$this->add_combo($id)];
        }
        foreach ($combos as $key => $combo) {
            $yarnAllocations = YarnAllocation::where('combo_id', $combo->id)->where('status', 1)->get();
            $combos[$key]['yarnAllocations'] = $yarnAllocations->toArray();
        }
        $orderInfo = Order::join('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->leftjoin('styles', 'styles.order_id', '=', 'orders.id')
            ->select('orders.order_no', 'buyers.buyer_name', 'styles.style_no')
            ->where('orders.id', $id)
            ->first();
        $orderId = $id;
        return view('viewers.bookingView')->with(compact('fabrications', 'combos', 'yarnBooking', 'orderId', 'orderInfo', 'remarks', 'summeries'));
    }
}
