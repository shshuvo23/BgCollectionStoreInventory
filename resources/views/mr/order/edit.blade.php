@php
$order_list = true;
@endphp
@extends('layouts.app')
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="mb-3 d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 text-capitalize">Update order</h6>
                </div>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back </a>
                </div>
            </div>
            <form action="{{ route('order.update', Crypt::encrypt($order->id)) }}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label class=""><strong>Buyer Name</strong> <span class="text-danger">*</span></label>
                        <select id="buyerId" class="select2 form-control" name="buyer_name">
                            <option value="" selected>--Select Buyer--</option>
                            @foreach ($buyers as $buyer)
                                <option {{ $order->buyer_id == $buyer->id ? 'selected' : '' }} value="{{ $buyer->id }}">
                                    {{ $buyer->buyer_name }}</option>
                            @endforeach
                        </select>
                        @error('buyer_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label class="text-capitalize"><strong>order no </strong> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="order_no" value='{{ $order->order_no }}'>
                        @error('order_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-warning mt-3" type="submit">{!!updateBtn()!!}</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endsection
