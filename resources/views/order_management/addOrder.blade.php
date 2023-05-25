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
     <div class="br-section-wrapper mt-4">
        <div  class="d-flex justify-content-end  align-items-center mb-4">
            <div>
               <a href="{{ route('order.management') }}" class="btn btn-sm btn-primary text-white"><i class=""></i><span class="pl-2">Orders</span></a>
            </div>
       </div>
        <oder-management/>
    </div>
</div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#buyer").select2({
                tags: true
            });
            $("#status").select2({
                tags: true
            });

        });
    </script>

    <script>


    </script>


@endsection



