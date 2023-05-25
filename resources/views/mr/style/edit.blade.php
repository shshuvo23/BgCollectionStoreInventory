@php
    $style_page = true;
@endphp
@extends('layouts.app')
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="mb-3 d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Update Style</h6>
                </div>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back </a>
                </div>
            </div>
            <form action="{{ route('style.update', Crypt::encrypt($style->id)) }}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label class=""><strong>Order No</strong> <span class="text-danger">*</span></label>
                        <select id="buyerId" class="select2 form-control" name="order_no">
                            <option value="" selected>--Select Order--</option>
                            @foreach ($orders as $order)
                                <option {{ $order->id == $style->id ? 'selected' : '' }} value="{{ $order->id }}">
                                    {{ $order->order_no }}</option>
                            @endforeach
                        </select>
                        @error('order_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label class=""><strong>Style No</strong> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="style_no" value='{{ $style->style_no }}'>
                        @error('style_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-warning mt-3" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                    Update</button>
            </form>
        </div>
    </div>
@endsection
