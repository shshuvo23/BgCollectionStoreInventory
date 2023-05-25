
@php
    $order_list = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <style>
        .ancor_link{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="d-flex justify-content-between  mb-3">
                <div>
                    <h2 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Search buyer wise orders</h2>
                </div>
                <div>
                    @include('mr.short_code.backbutton')
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-6 col-xs-6 col-sm-6">
                    <select class="form-control" id="buyerId" onchange="redirect()">
                        <option selected value="">All Buyer</option>
                        @foreach (DB::table('buyers')->get(['id', 'buyer_name']) as $buyer)
                            <option {{ $buyer_id == $buyer->id ? 'selected' : '' }}
                                value="{{ Crypt::encrypt($buyer->id) }}">
                                {{ $buyer->buyer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Orders of <span class="buyer-name"></span></h6> --}}

            <div id="order_table" class="table-responsive">
                @include('mr.short_code.order_list')
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        function redirect() {
            var buyerId = $('#buyerId').val();
            window.location.href = "{{ route('order.list') }}" + '/' + buyerId;
        }
        function anchorTag(link){
            window.location = link;
        }
    </script>
@endsection
