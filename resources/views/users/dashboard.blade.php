@php
    $dashboard = true;
@endphp
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row row-sm">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-teal rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-tshirt-outline tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Style</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $styles }}</p>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
            <div class="bg-danger rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-ios-person-outline tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Today Buyer
                        </p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $buyers }}</p>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="bg-primary rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Order</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $orders }}</p>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="bg-br-primary rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-ios-person-outline  tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Receivers
                        </p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{ $receivers }}</p>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
    </div><!-- row -->
</div>

@endsection
