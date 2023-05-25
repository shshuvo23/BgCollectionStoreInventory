<?php

namespace App\Http\Controllers;

use App\Models\YarnBooking;
use  App\Models\Combo;
use App\Models\Order;
use  App\Models\YarnAllocation;
use  App\Models\Fabrication;
use  App\Models\FebricPart;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class YarnBookingController extends Controller
{
   public function create(){
    $yarnBooking= YarnBooking::where('order_id',1)->first();
     return view('mr.yarn.yearnBooking',compact('yarnBooking'));
   }
   public function remarks(Request $request){

    $remarksInserOrNot = $request->remarksInserOrNot;
    $orderId = $request->orderId;
    $yarnBooking= YarnBooking::where('order_id',$orderId)->first();

    if(!$yarnBooking){
        $yarnBooking = new YarnBooking;
        $yarnBooking->created_by = auth()->user()->id;
        $yarnBooking->order_id = $orderId;
        $yarnBooking->save();
        $remark="";}
    else{
        $remark = $yarnBooking->remarks;
    }

    if($remarksInserOrNot=='true'){
        if($remark==""||$remark==null){
            $remark=' ';

        }
        else{
            $remark.='勘 ';

        }

        $yarnBooking->remarks = $remark;
        $yarnBooking->updated_by = auth()->user()->id;
        $yarnBooking->update();
    }
    $remarks = explode("勘", $remark);
    if($remark==''||$remark==null||$remarks==null){
        $remarks =[];
    }

    return view('mr.yarn.remarkList',compact('remarks','orderId'));

   }

   public function updateRemarks(Request $request){
      $order_id = $request->orderId;
      $remark = $request->remarks;
      $index = $request->index;

      $yarnBooking = YarnBooking::where('order_id', $order_id)->first();
      if(!$yarnBooking){
        $yarnBooking = new YarnBooking;
        $yarnBooking->order_id = $order_id;
        $yarnBooking->created_by = auth()->user()->id;
        $yarnBooking->save();
      }
      $remarks = $yarnBooking->remarks;
      if(!$remarks){
        $remarks = ' ';
      }
      $remarksItems = explode("勘", $remarks);
      $remarksItems[$index] = $remark;
      $yarnBooking->remarks = implode("勘", $remarksItems);
      $yarnBooking->updated_by = auth()->user()->id;
      $yarnBooking->update();
   }

    public function getSummery(Request $request){
        $summeryInserOrNot = $request->summeryInserOrNot;
        // $summeryInserOrNot = 'true';
        $orderId = $request->orderId;
        $yarnBooking= YarnBooking::where('order_id',$orderId)->first();

        if(!$yarnBooking){
            $yarnBooking = new YarnBooking;
            $yarnBooking->created_by = auth()->user()->id;
            $yarnBooking->order_id = $orderId;
            $yarnBooking->summery="";
            $yarnBooking->save();
            $summery="";
        }
        else{
            $summery = $yarnBooking->summery;
            if($summery==null){
                $yarnBooking->summery="௱ ௱ ";
                $yarnBooking->update();
                $summery= "௱ ௱ ";
            }
        }
        if($summeryInserOrNot=='true'){
            if($summery==""||$summery==null){
                $summery='௱ ௱ ';
            }
            else{
                $summery.='勘௱ ௱ ';
            }

            $yarnBooking->summery = $summery;
            $yarnBooking->updated_by = auth()->user()->id;
            $yarnBooking->update();
        }
        if( $summery == null){
            $summeries = [];
        }
        else $summeries = explode("勘", $summery);
        if($summeries==''||$summeries==null||$summeries==null){
            $summeries =[];
        }
        for($i=0; $i<count($summeries); $i++){
            $summeries[$i] = explode("௱", $summeries[$i]);
        }
        return view('mr.yarn.summeryList',compact('summeries'));
    }

    public function updateSummery(Request $request){
        $order_id = $request->orderId;
        $index = $request->index;
        $item = $request->item;
        $fabric = $request->fabric;
        $qty = $request->qty;

        $yarnBooking = YarnBooking::where('order_id', $order_id)->first();
        if(!$yarnBooking){
            $yarnBooking = new YarnBooking;
            $yarnBooking->order_id = $order_id;
            $yarnBooking->created_by = auth()->user()->id;
            $yarnBooking->save();
        }
        $summery = $yarnBooking->summery;
        if(!$summery){
            $remarks = "௱ ௱ ";
        }

        $summeryItems = explode("勘", $summery);
        $summeryItems[$index] = $item."௱".$fabric."௱".$qty;

        $yarnBooking->summery = implode("勘", $summeryItems);
        $yarnBooking->updated_by = auth()->user()->id;
        $yarnBooking->update();

    }

   public function storeYarn(Request $request){
        $order_id=$request->orderId;
        $process_loss=$request->process_loss;
        $extra_cutting=$request->extra_cutting;
        $issuing_date=$request->issuing_date;
        $shipment_date=$request->shipment_date;
        $changesField = $request->changesField;
        $orderQty = $request->order_qty;

        $yarnBookingItem= YarnBooking::where('order_id',$order_id)->first();
        if(!$yarnBookingItem){
            $yarnBookingItem = new YarnBooking;
            $yarnBookingItem->order_id = $order_id;
            $yarnBookingItem->process_loss = $process_loss;
            $yarnBookingItem->extra_cutting = $extra_cutting;
            $yarnBookingItem->issuing_date = $issuing_date;
            $yarnBookingItem->order_qty = $orderQty;
            $yarnBookingItem->shipment_date = $shipment_date;
            $yarnBookingItem->created_by = auth()->user()->id;
            $yarnBookingItem->save();
        }else{
            $yarnBookingItem->process_loss = $process_loss;
            $yarnBookingItem->extra_cutting = $extra_cutting;
            $yarnBookingItem->issuing_date = $issuing_date;
            $yarnBookingItem->shipment_date = $shipment_date;
            $yarnBookingItem->order_qty = $orderQty;
            $yarnBookingItem->updated_by = auth()->user()->id;
            $yarnBookingItem->update();
        }

   }

   public function pdfYarnBookingSheet($id){
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
        //return view('mr.yarn.yarnBookingTable')->with(compact('fabrications','combos','yarnBooking','orderId','orderInfo'));



        return $pdf = Pdf::loadView('pdf.yarnBookinSheet',[
            'fabrications'=>$fabrications,
            'combos' => $combos,
            'yarnBooking' => $yarnBooking,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
        ])->setPaper('a4', 'landscape');
   }


   public function printBookingSheet(Request $request, $id){
        // $pdf = $this->pdfYarnBookingSheet($id);
        // return $pdf->stream();

        $yarnBooking= YarnBooking::where('order_id',$id)->first();

        $summery = '';
        $remark = '';
        if($yarnBooking){
            $remark = $yarnBooking->remarks;
            $summery = $yarnBooking->summery;
        }
        $remarks = explode("勘", $remark);
        if($remark==''||$remark==null||$remarks==null){
            $remarks =[];
        }



        if( $summery == null){
            $summeries = [];
        }
        else $summeries = explode("勘", $summery);
        if($summeries==''||$summeries==null||$summeries==null){
            $summeries =[];
        }
        for($i=0; $i<count($summeries); $i++){
            $summeries[$i] = explode("௱", $summeries[$i]);
        }



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
        return view('pdf.yarnBookinSheet')->with(compact('fabrications','combos','yarnBooking','orderId','orderInfo', 'remarks', 'summeries'));
   }

    public function sendBooking(Request $request){
        if(!Order::find($request->orderId)){return 'error';}
        $yarnBooking= YarnBooking::where('order_id',$request->orderId)->first();
        if(!$yarnBooking){
            $yarnBooking = new YarnBooking;
            $yarnBooking->order_id = $request->orderId;
            $yarnBooking->status = "booked";
            $yarnBooking->created_by = auth()->user()->id;
            $yarnBooking->save();
        }
        else{
            $yarnBooking->status = "booked";
            $yarnBooking->updated_by = auth()->user()->id;
            $yarnBooking->update();
        }
        return 'success';
    }

}
