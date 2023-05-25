@php
$orderManagement = true;
@endphp
@extends('layouts.app')
 @section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="br-pagebody mg-t-5 pd-x-30">

    <div class="br-section-wrapper mt-5">
        <div  class="d-flex justify-content-end  align-items-center mb-4">
            <div>
                <a href="{{ route('shit.order') }}" class="btn btn-sm btn-secondary text-white"><i class="fa fa-plane"></i><span class="pl-2">Shifted Order</span></a>|
                <a href="{{ route('download.order') }}" class="btn btn-sm btn-info text-white"><i class="fa fa-download"></i></i><span class="pl-2">Download</span></a>|
                <a href="{{ route('print.order') }}" class="btn btn-sm btn-warning text-white"><i class="fa fa-print"></i></i><span class="pl-2">Print</span></a>
                @if(auth()->user()->role_id == 6)|
                   <a href="{{ route('add.order') }}" class="btn btn-sm btn-primary text-white"><i class=""></i><span class="pl-2">Add Order</span></a>
                @endif
            </div>
       </div>
          <oder-list></oder-list>
    </div>


    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
           $(document).ready(function() {
            // alert('hello');
            $("#buyerSelect").select2({
                tags: true
            });
            $("#status").select2({
                tags: true
            });

        });

        function  editModal(){
        }
    </script>

@endsection
