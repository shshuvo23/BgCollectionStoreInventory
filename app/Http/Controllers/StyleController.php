<?php

namespace App\Http\Controllers;

use App\Models\Style;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    public function index(){
        //   return "Hello";
        // $styles = StockOut::join('styles','styles.id','=','stock_outs.style_id')
        //                     ->join('orders', 'styles.order_id', '=', 'orders.id')
        //                     ->join('buyers','orders.buyer_id', '=', 'buyers.id')
        //                     ->select('styles.id','styles.style_no','buyers.buyer_name')
        //                     ->get();

          $styles = Style::leftJoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftJoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.order_id', '!=', null)
            ->select('styles.id', 'styles.style_no', 'buyers.buyer_name',)
            ->orderBy('styles.id', 'desc')->get();
         return response()->json($styles);
    }
}
