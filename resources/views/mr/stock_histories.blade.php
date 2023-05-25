@php
    $search_booking = true;
@endphp
@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-5">
            <div class="d-flex justify-content-between  mb-3">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Stock Histories</h6>
                </div>
                <div>
                    @include('mr.short_code.backbutton')
                </div>
            </div>
            <div id="stock_in_section"  class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Style No</th>
                            <th scope="col">Accessories Name</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Color Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Callan No</th>
                            <th scope="col">MRR No</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Collected By</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stock_in_histories as $stock_in_history)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $stock_in_history->style_no }}</td>
                                <td>{{ $stock_in_history->accessories_name }}</td>
                                <td>{{ $stock_in_history->unit }}</td>
                                <td>{{ $stock_in_history->color_name }}</td>
                                <td>{{ $stock_in_history->size }}</td>
                                <td>{{ $stock_in_history->supplier_name }}</td>
                                <td>{{ $stock_in_history->callan_no }}</td>
                                <td>{{ $stock_in_history->mrr_no }}</td>
                                <td>{{ $stock_in_history->quantity }}</td>
                                <td>{{ $stock_in_history->collected_by }}</td>
                                <td>{{ $stock_in_history->received_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
