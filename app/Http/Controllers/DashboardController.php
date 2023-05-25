<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Unit;
use App\Models\Buyer;
use App\Models\Color;
use App\Models\Order;
use App\Models\Style;
use App\Models\Receiver;
use App\Models\Supplier;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // function combination($n){
    //     if($n==0) return;
    //     echo $n;
    //     for($i=0; $i<$n; $i++){
    //         $this->combination(--$n);
    //     }

    // }

    public function index()
    {

        // $this->combination(4);

        // return;


        $role_id = auth()->user()->role_id;
        if ($role_id == 1) {
            return redirect()->route('super_admin_dashboard');
        } elseif ($role_id == 2 or $role_id == 6) {
            return redirect()->route('mr_dashboard');
        } elseif ($role_id == 3) {
            return redirect()->route('stock_in_dashboard');
        } elseif ($role_id == 4) {
            return redirect()->route('stockOutCreate');
        } elseif ($role_id == 5) {
            return redirect()->route('viewer_dashboard');
        } elseif ($role_id == 7) {
            return redirect()->route('knitting_dashboard');
        } elseif ($role_id == 8) {
            return redirect()->route('viewerCalender_dashboard');
        } else {
            return abort('403');
        }
    }

    public function  stockOutDashboard()
    {
        $buyer = Buyer::count();
        $style = Style::count();
        $order = Order::count();
        $receiver = Receiver::count();
        $page_title = 'Dashboard';
        $page_message = 'Store Management Application';
        return view('dashboard')->with(compact('page_title', 'page_message', 'buyer', 'style', 'order', 'receiver'));
    }
}
