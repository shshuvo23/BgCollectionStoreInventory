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
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Booking History</h6>
                </div>
                <div>
                    @include('mr.short_code.backbutton')
                </div>
            </div>
            <div id="stock_in_section" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Style No</th>
                            <th scope="col">Accessories Name</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Color Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Garments Quantity</th>
                            <th scope="col">Requered Quantity</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking_histories as $bookingHistory)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $bookingHistory->style_no }}</td>
                                <td>{{ $bookingHistory->accessories_name }}</td>
                                <td>{{ $bookingHistory->unit }}</td>
                                <td>{{ $bookingHistory->color_name }}</td>
                                <td>{{ $bookingHistory->size }}</td>
                                <td>{{ $bookingHistory->garments_quantity }}</td>
                                <td>{{ $bookingHistory->requered_quantity }}</td>
                                <td>{{ $bookingHistory->created_at }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
