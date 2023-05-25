<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Order;
use App\Models\Style;
use Illuminate\Http\Request;

class ViewCalenderController extends Controller
{
    public function exportCalenderDashboard()
    {
        return view('viewerCalender.dashboard');
    }
}
