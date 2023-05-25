<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Style;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function buyer_info($style_id)
    {
        return  Style::join('orders', 'orders.id', '=', 'styles.order_id')
            ->join('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.id', $style_id)
            ->select('styles.style_no', 'orders.order_no', 'buyers.buyer_name')
            ->first();
    }
    public function inventory_pdf($style_id)
    {
        $style_id = custom_decrypt($style_id);
        $inventories =  get_inventories($style_id);
        $inventory_info = $this->buyer_info($style_id);
        return $pdf = Pdf::loadView('pdf.inventory_report', compact('inventories', 'inventory_info'))->setPaper('a4', 'landscape');
    }

    public function print_invenntory_report($style_id)
    {
        $pdf = $this->inventory_pdf($style_id);
        return $pdf->stream();
    }

    public function download_invenntory_report($style_id)
    {
        $id = custom_decrypt($style_id);
        $buyer_info =  $this->buyer_info($id);
        $pdf = $this->inventory_pdf($style_id);
        $name = $buyer_info->buyer_name . " " . $buyer_info->order_no . " " . $buyer_info->style_no . " " . date('d M Y').'.pdf';
        return $pdf->download($name);
    }
}
