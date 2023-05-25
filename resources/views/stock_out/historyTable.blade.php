<table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Style No</th>
        <th scope="col">Receiver Name</th>
        <th scope="col">Line No</th>
        <th scope="col">ACtion</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($stockOuts as $item)
        <tr >
            <th scope="row">{{$loop->index+1}}</th>
            <td>{{$item->style_no}}</td>
            <td>{{$stockOutHistory->receiver_name}}</td>
            <td>{{$stockOutHistory->line_no}}</td>

            <td>...</td>
          </tr>
        @endforeach

    </tbody>
  </table>
  {{-- @extends('layouts.app')

  @section('css')
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 @endsection

 @section('content')
 @section('content')
     <div class="br-pagebody mg-t-5 pd-x-30">
         <div class="br-section-wrapper mt-4">
             <div class="d-flex justify-content-between">
                 <div>
                     <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Booking</h6>
                     <p class="mg-b-25 mg-lg-b-50">Booking Accessories</p>
                 </div>
                 <div>
                     <a class="btn btn-warning" href="{{ route('style.create') }}"><i class="fa fa-plus"></i> Add Style</a>
                 </div>
             </div>

                 <div class="row">
                     <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                         <label class=""><strong>Style Number</strong> <span class="text-danger">*</span></label>
                         <select class="select2 form-control is_invalid" id="style_no" name="style_no" onchange="getStockHistory()">
                             <option value="" selected>--Select Style--</option>
                             @foreach ($styles as $style)
                                 <option value="{{ $style->id }}">
                                     {{ $style->style_no }}</option>
                             @endforeach
                         </select>
                         <span id="styleNoError" class="text-danger"> </span>
                     </div>


                 </div>
                 <div class="row clearfix">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                         <div class="card">
                             <div class="body printable" >
                                 <div class="table-responsive printable" id="stock_out_history">
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>

         </div>
         <div id="booking-list">

         </div>
     </div>
 @endsection
 @endsection

 @section('js')
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script>
        $(document).ready(function() {
             $(".select2").select2({
                 tags: false
             });

         });

 </script>

 <script>
     // function getStockHistory(){
     //     let style_id = $('#style_no').val();
     //     $.get('{{ route('stock_out') }}',{style_id:style_id}, function(data){
     //         // console.log(data);
     //          $('#stock_out_history').innerHTML = data;
     //     });
     // }

       function getStockHistory(){
         let style_id = $('#style_no').val();
         $.get('{{ route('stock_out')}}', function(data){
             console.log(data);
             //  $('#stock_out_history').innerHTML = data;
         });
     }
 </script>


 @endsection --}}
