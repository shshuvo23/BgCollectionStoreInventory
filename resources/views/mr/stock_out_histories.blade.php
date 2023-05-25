@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-5">
            <div class="d-flex justify-content-between  mb-3">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Stock Out History</h6>
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
                            <th scope="col">Receiver Name</th>
                            <th scope="col">Line_no</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stock_out_histories as $stock_out_history)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $stock_out_history->style_no }}</td>
                                <td>{{ $stock_out_history->accessories_name }}</td>
                                <td>{{ $stock_out_history->unit }}</td>
                                <td>{{ $stock_out_history->color_name }}</td>
                                <td>{{ $stock_out_history->size }}</td>
                                <td>{{ $stock_out_history->receiver_name }}</td>
                                <td>{{ $stock_out_history->line_no }}</td>
                                <td>{{ $stock_out_history->quantity }}</td>
                                <td>{{ $stock_out_history->stock_out_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


