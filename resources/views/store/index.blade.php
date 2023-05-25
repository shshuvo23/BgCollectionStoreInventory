







{{-- @php
    $dashboard = true;
@endphp
@extends('layouts.app')
@section('css')
<link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection
@section('content') --}}
    {{-- <div class="br-pagebody mg-t-5 pd-x-30"> --}}


    <div class="br-section-wrapper mt-5">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Style List</h6>
        <p class="mg-b-25 mg-lg-b-50">Store Style List </p>
        <div id="stock_in_section " class="table-responsive">
            <table id="style-table" class="table table-hover " >
                <thead >
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Style No</th>
                    <th scope="col">Buyer Name</th>
                    <th scope="col">Order No</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class='clickable-row' data-href='{{route('view_inventory', $order->id)}}'>
                            <th scope="row">{{$loop->index+1}}</th>
                            <td>{{$order->style_no}}</td>
                            <td>{{$order->buyer_name}}</td>
                            <td>{{$order->order_no}}</td>
                            <td><span class="badge bg-{{( $order->status == 1 ) ? "success" : "info"}}" >{{get_style_status($order->status)}}</span></td>
                            <td><a onclick="setSession('back', 0, '{{route('view_inventory', Crypt::encrypt($order->id))}}')" href="javascript:void(0)" class="btn btn-sm btn-primary">View Inventory</a></td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>


    {{-- </div> --}}

{{-- @endsection --}}
{{-- @section('js')
 <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('#style-table').DataTable();
        $(".clickable-row").click(function() {
            //window.location = $(this).data("href");
        });
    });
</script>
@endsection --}}


