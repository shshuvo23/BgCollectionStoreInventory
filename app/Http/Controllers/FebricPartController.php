<?php

namespace App\Http\Controllers;

use App\Models\FebricPart;
use Illuminate\Http\Request;

class FebricPartController extends Controller
{
    public function index(){
        return view('test.index');
    }

    public function newFebricItem(Request $request){
        $xyz = $request->xyz;
        $orderId = $request->orderId;
         if($xyz=='true'){
            $febricPart = new FebricPart;
            $febricPart->order_id = $orderId;
            $febricPart->created_by = auth()->user()->id;
            $febricPart->save();
         }
        $febricParts = FebricPart::where('order_id',$orderId)->get();
        return view('test.newFebric',compact('febricParts'));
    }

    public function storeFabric(Request $request){
        $name = $request->name;
        $value = $request->value;
        $id = $request->id;

        $febricPart = FebricPart::findOrFail($id);
        $febricPart->name = $name;
        $febricPart->value = $value;
        $febricPart->updated_by = auth()->user()->id;
        $febricPart->update();
        return 'Okay';



    }
}
