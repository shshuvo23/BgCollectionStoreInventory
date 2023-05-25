@php
    $dashboard = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    {{-- <div class="br-pagebody mg-t-5 pd-x-30"> --}}
        <div class="row row-sm">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-teal rounded overflow-hidden">
                    <div class="pd-25 d-flex align-items-center">
                        <img src="{{ asset('assets/img/buyer.png') }}" alt="">
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">total Buyer
                            </p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $total_buyer }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="bg-danger rounded overflow-hidden">
                    <div class="pd-25 d-flex align-items-center">
                        <img src="{{ asset('assets/img/order.png') }}" alt="">
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Order</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $total_order }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-primary rounded overflow-hidden">
                    <div class="pd-25 d-flex align-items-center">
                        <img src="{{ asset('assets/img/running.png') }}" alt="">
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Running Style
                            </p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $total_running_style }}</p>
                            <span class="tx-11 tx-roboto tx-white-6">Total Style {{ $total_style }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-br-primary rounded overflow-hidden">
                    <div class="pd-25 d-flex align-items-center">
                        <img src="{{ asset('assets/img/completed.png') }}" alt="">
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Completed Style
                            </p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $total_completed_style }}</p>
                            <span class="tx-11 tx-roboto tx-white-6">Total Style {{ $total_style }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endsection
