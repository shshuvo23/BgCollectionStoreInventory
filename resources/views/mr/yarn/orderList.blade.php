@php
    $yarn_booking = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-5">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Order List</h6>
                </div>
                <div>
                    <a class="btn btn-warning" href="{{ route('order.create') }}"><i class="fa fa-plus"></i>Add Order</a>
                </div>
            </div>

           <div class="d-none justify-content-end mb-3">
                <div>
                    <label for="" style>Search</label>
                    <input class="form-control" type="search" style="height:2rem;">
                </div>
           </div>

            <div id="mrr_list" style=" width: 100%;">
                <table>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="table">
                                <td>{{$order->buyer_name}}</td>
                                <td>{{$order->order_no}}</td>
                                <td><a href="{{route('yarn_booking', $order->id)}}" class="btn btn-sm btn-primary">Booking</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


