<?php

namespace App\Http\Controllers;

use App\Models\Receiver;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
     public function index(){
            return view('receivers.index',[
                'page_title' => 'Receivers',
                'page_message' => 'Receivers Management',
                'page_message' => 'Receivers Management',
            ]);
     }

     public function getReceivers(){
          $receivers = Receiver::orderBy('id','desc')->paginate(10);
          return response()->json( $receivers );
     }

     public function deleteReceiver(Request $request){
          $id = $request->params['id'];
          $receiver = Receiver::findOrFail($id);
          $receiver->delete();
          return response()->json(['success',"Delete Success"]);
     }

     public function edit(Request $request , $id){
        //    return $id;
         $receiver = Receiver::find($id);
         return response()->json($receiver);
     }

     public function update(Request $request, $id){
        $name = $request->params['name'];
        $receiver = Receiver::find($id);
        $receiver->receiver_name = $name;
        $receiver->created_by = auth()->user()->id;
        $receiver->update();
        return response()->json(['success',"Update Success"]);
     }

     public function delRecv($id){
        return $id;
        // return base64_decode($id);
     }
}
