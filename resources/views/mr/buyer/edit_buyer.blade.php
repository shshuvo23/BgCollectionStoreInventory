@php
$buyer_list = true;
@endphp
@extends('layouts.app')
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="mb-3 d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Update Buyer</h6>
                </div>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back </a>
                </div>
            </div>
            <form action="{{ route('buyer.update', Crypt::encrypt($buyer->id)) }}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label class=""><strong>Buyer Name</strong> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="buyer_name" value='{{ $buyer->buyer_name }}'>
                        @error('buyer_name')
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
@endsection
