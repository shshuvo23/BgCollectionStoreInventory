<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Buyer;
use App\Models\Color;
use App\Models\Style;
use App\Models\Receiver;
use App\Models\StockOut;
use App\Models\Accessory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\StockOutHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class StockOutController extends Controller
{
    public function StockOutDashboard(){
         $buyer = Buyer::count();
         return view('dashboard',
        [   'buyer' => $buyer,
            'page_title' => 'Dashboard',
            'page_message' => 'Store Management Application',
        ]);
    }

    public function stockOutCreate(){

         return view('stock_out.create',[
            'page_title' => 'Stock Out',
            'page_message' => 'Store stock out',
         ]);
    }

    public function getData(){

          $styles = Style::join('orders','orders.id','=','styles.order_id')
                        ->join('buyers','buyers.id','=','orders.buyer_id')
                        ->select('styles.id','styles.style_no','buyers.buyer_name','orders.order_no','styles.created_at')
                        ->orderBy('styles.id', 'desc')->get();
            foreach($styles as $key => $style){
                $style->created_at_format  = $style->created_at->format('My');
                $styles[$key] = $style;
            }
          $receivers = Receiver::orderBy('id', 'desc')->get();
          return response()->json(['styles'=>$styles ,'receivers'=>$receivers]);
    }

    public function getAccessories(Request $request){


         // return $request->tags;
        $style_id =  $request->style_id;
        $tags = $request->tags;
        $keys = ['','',''];
        $kdx = 0;


         if($tags){
            for($idx = 0; $idx < count($tags); $idx++){
                $keys[$kdx] = $tags[$idx];
                $kdx++;
            }
         }


        $dx = [
            [0,0,1,1,2,2],
            [1,2,0,2,0,1],
            [2,1,2,0,1,0]
        ];

            $accessoriesStock = Inventory::join('accessories','inventories.accessories_id','=',
            'accessories.id')
            ->join('units','accessories.unit_id','=','units.id')
            ->leftJoin('colors','colors.id','=','inventories.color_id')
            ->leftJoin('sizes','sizes.id','=','inventories.size_id')
            ->where('inventories.style_id',$style_id)
            ->where('inventories.stock_quantity','>',0)
            ->where(function($query)use($keys,$dx){
                if($keys[0] != "" || $keys[1] != "" || $keys[2] != ""){
                    for($i=0; $i<6; $i++){
                        $query->orWhere(function($query1)use($keys,$dx,$i){
                            $query1->where('accessories.accessories_name','LIKE',"%{$keys[$dx[0][$i]]}%")
                            ->where('colors.color_name','LIKE',"%{$keys[$dx[1][$i]]}%")
                            ->where('sizes.size','LIKE',"%{$keys[$dx[2][$i]]}%");
                        });
                    }
                }else{
                    return $query;
                }
            })
            ->select('accessories.accessories_name','units.unit','sizes.size','colors.color_name','inventories.stock_quantity', 'inventories.id as inventory_id','inventories.consumption','inventories.bar_or_ean_code','inventories.requered_quantity')
            ->orderBy('accessories.accessories_name', 'asc')
            ->get();

        return response()->json(["stockAccessories"=>$accessoriesStock]);

    }

    public function stockOut(Request $request){

      $data =$request->params['data'];
        $quantity =  $request->params['quantity'];

        $dataRules =[
            'style_id' => ['required'],
            'receiver_id'=>['required'],
            'line_number'=>['required','string'],
            'date'=>['required','date'],
        ];
        $isError = false;
        $validator = Validator::make($data, $dataRules);
            if($validator->fails()) {
            $isError = true;
            return response()->json([
                'isError' => true,
                'errors'=>$validator->errors(),
                'error_type' => 'validation_error'
            ]);

            }else{

            $isErrorsHas = false;
            $quantityError = [];

            if (is_numeric($data['receiver_id'])) {

                $receiver = Receiver::find($data['receiver_id']);

                if ($receiver) {
                    $receiverId = $receiver->id;
                } else {
                    $errors['receiver_id'] = ['Enter valid Receiver Name'];
                    $isError = true;
                }
            } else {
                $receiver = Receiver::where('receiver_name',$data['receiver_id'])->first();
                if ($receiver) {
                    $receiverId = $receiver->id;
                }else {
                    try {
                        $receiver = new Receiver;
                        $receiver->receiver_name = $data['receiver_id'];
                        $receiver->created_by = auth()->user()->id;
                        $receiver->save();

                        $receiverId = $receiver->id;
                    } catch (\Throwable $e) {
                        $errors['error'] = 'Operation failed';
                        return $errors;
                    }
                }
            }


            if($isError){
                return response()->json([
                    'isError' => true,
                    'errors'=> $errors,
                    'error_type' => 'validation_error'
                ]);
            }

            foreach($quantity as $key => $val ){
                $inventories = Inventory::findOrFail($key);
                if( $inventories->stock_quantity < $val ){
                    $isErrorsHas = true;
                    $quantityError[$key] = "Quantity is not available";
                }
                // if($inventories->stock_quantity <= $val){
                //     $isErrorsHas = true;
                //     $quantityError[$key] = "Stock Out qty can't be more thant'+$inventories->stock_quantity";
                // }
            }



            if($isErrorsHas){
                return response()->json([
                    'isError' => true,
                    'quantityErr'=>$quantityError,
                    'error_type' => 'quantityErrors'
                ]);
            }
            $stockOuts = '';
            $isSuccess = false;
           //For Stock Out Table
            if(count($quantity) > 0){
                $stock_out = new StockOut;
                $stock_out->style_id = $data['style_id'];
                $stock_out->receiver_id = $receiverId;
                $stock_out->line_no = $data['line_number'];
                $stock_out->save();



            //For Stock Out History
            foreach($quantity as $key => $val){
                $inventories = Inventory::findOrFail($key);
                $stock_out_history = new StockOutHistory;
                $stock_out_history->stock_out_id = $stock_out->id;
                $stock_out_history->stock_out_date   = $data['date'];
                $stock_out_history->accessories_id   = $inventories->accessories_id;
                $stock_out_history->color_id         = $inventories->color_id;
                $stock_out_history->size_id          = $inventories->size_id;
                $stock_out_history->quantity         = $val;
                $stock_out_history->created_by       = auth()->user()->id;
                $stock_out_history->save();
                $inventories->stock_quantity -= $val;
                $inventories->update();
                $isSuccess = true;

                $stockOut = StockOut::join('styles','styles.id','=','stock_outs.style_id')->join('receivers','receivers.id','=','stock_outs.receiver_id')
                ->select('styles.style_no','receivers.receiver_name','stock_outs.line_no','stock_outs.created_at as date','stock_outs.id')
                ->orderBy('stock_outs.id', 'desc')->take(10)->get();

                $stockOuts = view('stock_out.stockOutHistories',compact('stockOut'));
            }

        }

            return response()->json([
                'isError' => false,
                'isSuccess' => $isSuccess,
                'stockOuts'=> (string)$stockOuts,
            ]);
        }


    }

    protected function stockOutHistory(){

        $stockOuts = StockOut::join('styles','stock_outs.style_id','=','styles.id')
        ->join('receivers','stock_outs.receiver_id','=','receivers.id')
        // ->where([$condition])
        ->select('styles.style_no','receivers.receiver_name','stock_outs.line_no','stock_outs.id','stock_outs.id')
        ->orderBy('id','desc')
        ->get(10);
        // return view('stock_out.stockOuthistory',compact('stockOuts'));
      //   return response()->json([
      //     'stockOut'=> $stockOut,
      //     'stock_out_role'=>$stock_out_role

      // ]);
           return view('stock_out.stockOutHistory',[
            'stockOuts'=>$stockOuts,
            'page_title' => 'Stock Out History',
            'page_message' => 'Store stock out history',
           ]);
    }

    protected function stockOutInfo(Request $request){

        $searchKey = $request->searchBy;
        $style_id = $request->styleId;

        if( $style_id == null &&    $searchKey == null){
            $condition = ['stock_outs.style_id' , '!=',  0,];

        }else{
            // $condition = ['stock_outs.style_id' , $style_id,'receivers.receiver_name','like','%'.$searchKey.'%','stock_outs.line_no','like','%'.$searchKey.'%','styles.style_no','like','%'.$searchKey.'%'];
            $condition = ['stock_outs.style_id' , $style_id];
        }

        $stock_out_role = '';
        if(auth()->user()->role_id == 4){
            $stock_out_role = 1;
        }else{
            $stock_out_role = 0;
        }



    }

    public function stockOutHistoryInfo($id){
        $id = Crypt::decrypt($id);
         $stockOutHistories = StockOutHistory::join('accessories', 'accessories.id', '=', 'stock_out_histories.accessories_id')
        ->join('units', 'units.id', '=', 'accessories.unit_id')
        ->leftJoin('colors', 'colors.id', '=', 'stock_out_histories.color_id')
        ->leftJoin('sizes', 'sizes.id', '=', 'stock_out_histories.size_id')
        ->where('stock_out_histories.stock_out_id',$id)
        ->select(
            'stock_out_histories.id',
            'accessories.accessories_name',
            'accessories.id as access_id',
            'units.unit',
            'colors.color_name',
            'sizes.size',
            'stock_out_histories.quantity',
            'stock_out_histories.stock_out_date',
        )
        ->orderBy('id','desc')
        ->get();



         $style_and_receiver_name=  StockOut::join('styles','styles.id','=','stock_outs.style_id')
                                 ->join('receivers','receivers.id','=','stock_outs.receiver_id')
                                 ->select('styles.style_no','receivers.receiver_name','receivers.id')
                                 ->where('stock_outs.id',$id)
                                 ->first();
        return view('stock_out.stock_out_history_info',[
            'page_title' => 'Stock Out Histories Details',
            'page_message' => 'Store stock out',
            'stockOutHistories' => $stockOutHistories,
            'history_info' =>$style_and_receiver_name,
            'stock_out_histories_id' =>$id
         ]);
    }

    public function pdfStockOutInfo($id){

        $style_and_receiver_name=  StockOut::join('styles','styles.id','=','stock_outs.style_id')
        ->join('receivers','receivers.id','=','stock_outs.receiver_id')
        ->join('orders','styles.order_id','=','orders.id')
        ->join('buyers','buyers.id','=','orders.buyer_id')
        ->select('styles.style_no','receivers.receiver_name','stock_outs.line_no','buyers.buyer_name')
        ->where('stock_outs.id',$id)
        ->first();

            $stockOutHistories = StockOutHistory::
                join('accessories', 'accessories.id', '=', 'stock_out_histories.accessories_id')
               ->join('units', 'units.id', '=', 'accessories.unit_id')
               ->leftJoin('colors', 'colors.id', '=', 'stock_out_histories.color_id')
               ->leftJoin('sizes', 'sizes.id', '=', 'stock_out_histories.size_id')
               ->where('stock_out_id',$id)
               ->select(
                   'stock_out_histories.id',
                   'accessories.accessories_name',
                   'units.unit',
                   'colors.color_name',
                   'sizes.size',
                   'stock_out_histories.quantity',
                   'stock_out_histories.stock_out_date',
               )
               ->orderBy('id','desc')
               ->get(10);
             return $pdf = Pdf::loadView('pdf.stock_out_history',[
                'stockOutHistories'=>$stockOutHistories,
                'stock_out_id' => $id,
                'style_and_receiver_name'=>$style_and_receiver_name
             ])->setPaper('a4', 'landscape');
    }

    public function style_and_receiver_name($id){
        return StockOut::join('styles','stock_outs.style_id','=','styles.id')->join('receivers','receivers.id','=','stock_outs.receiver_id')->where('stock_outs.id',$id)->select('styles.style_no','receivers.receiver_name')->first();
    }

    public function printStockOutInfo($id)
    {

        $id = custom_decrypt($id);
        $pdf = $this->pdfStockOutInfo($id);
        return $pdf->stream();
    }

    public function downLoadStockOutInfo($id){
        $id = custom_decrypt($id);
        $pdf = $this->pdfStockOutInfo($id);
        $style_receiver_info = $this->style_and_receiver_name($id);
        $name = $style_receiver_info->receiver_name.'-'.$style_receiver_info->style_no.'.pdf';
        return $pdf->download($name);
    }

    public function editStockOutAccessories($id){
             $id = custom_decrypt($id);
                $stockOut = StockOutHistory::
                join('stock_outs','stock_outs.id','=','stock_out_histories.stock_out_id')
                ->join('accessories','stock_out_histories.accessories_id','=','accessories.id')
                ->leftJoin('sizes','stock_out_histories.size_id','=','sizes.id')
                ->leftJoin('colors','stock_out_histories.color_id','=','colors.id')
                ->join('receivers','receivers.id','stock_outs.receiver_id')
                ->where('stock_out_histories.id',$id)
                ->select('accessories.accessories_name as access_name','stock_out_histories.quantity','colors.color_name','sizes.size','stock_out_histories.stock_out_id as stock_out_id','stock_outs.line_no','sizes.id as size_id','colors.id as color_id','receivers.id as receiver_id','accessories.id as access_id','stock_outs.style_id')
                ->first();

              return view('stock_out.edit_stock_out_access',[
                'stockOut'=>$stockOut,
                'page_title' => 'Edit Stock Out Item',
                'page_message' => 'Edit Stock Out Item',
              ]);


    }

    public function updateEditedQty(Request $request, $id){
        $receiver_id = $request->receiver_id;
        $access_id = $request->access_id;
        $line_no = $request->line_no;
        $quantity = $request->quantity;
        $size_id = $request->size_id;
        $color_id = $request->color_id;
        $style_id = $request->style_id;


        // return  $receiver_id .' '. $access_id .' '. $line_no;
    $stock_out_histories = StockOutHistory::join('stock_outs','stock_outs.id','=',   'stock_out_histories.stock_out_id')
        ->where('stock_out_histories.stock_out_id',$id)
        ->where('stock_outs.receiver_id',$receiver_id)
        ->where('stock_outs.line_no',$line_no)
        ->where('stock_out_histories.accessories_id',$access_id)
        ->select('stock_out_histories.quantity','stock_out_histories.id')
        ->first();

     $inventory = Inventory::where('accessories_id',$access_id)->where('size_id',$size_id)->where('color_id',$color_id)->where('style_id',$style_id)->first();
         $newQty = "";
        if($stock_out_histories->quantity < $quantity){
           if( $inventory->stock_quantity >= $quantity){
                $newQty =  $quantity - $stock_out_histories->quantity;
                $stock_out_histories->quantity = $quantity;
                $stock_out_histories->update();
                $inventory->stock_quantity -= $newQty;
                $inventory->update();
           }else{
            return redirect()->back()->with('error','Quantity Not Available');
           }
        }else{
            $newQty = $stock_out_histories->quantity - $quantity;
            $stock_out_histories->quantity = $quantity;
            $stock_out_histories->update();
            $inventory->stock_quantity;
            $inventory->stock_quantity += $newQty;
            $inventory->update();
        }
        return redirect()->back()->with('success','Inventory Update Success');

    }

    public function editStockOutInfo($id){
        $id = Crypt::decrypt($id);
        $stockOut = StockOut::findOrFail($id);
        $receivers = Receiver::get();

        return view('stock_out.edit_stock_out_info',[
            'stockOut'=>$stockOut,
            'receivers'=>$receivers,
            'page_title' => 'Edit Receivers',
            'page_message' => 'Edit Receivers',
        ]);


    }

    public function updateStockOutInfo( Request $request,$id){
         $receiver = $request->receiver;
         $line_no = $request->line_no;
         $findReceiver = Receiver::where('id',$receiver)->first();
         if($findReceiver){
            $stockOutData = StockOut::findOrFail($id);
            $stockOutData->receiver_id = $receiver;
            $stockOutData->line_no = $line_no;
            $stockOutData->update();
            return redirect()->route('stock_out_history')->with('success','Receivers update successfully');
         }else{
             $receivers = new Receiver;
             $receivers->receiver_name = $receiver;
             $receivers->created_by    = auth()->user()->id;
             $receivers->save();

             $stockOutData = StockOut::findOrFail($id);
             $stockOutData->receiver_id = $receivers->id;
             $stockOutData->line_no = $line_no;
             $stockOutData->update();
             return redirect()->route('stock_out_history')->with('success','Receivers insert and  update successfully');

         }

    }

    public function encrypt(Request $request){
       $id = $request->id;
        return Crypt::encrypt($id);
    }

    public function shiftOrder(){

    }


}
