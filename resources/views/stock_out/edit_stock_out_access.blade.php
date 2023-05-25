@php
    $stock_out_history = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit Accessories Of {{ $stockOut->access_name }}</h6>
                </div>
            </div>
            @php

            @endphp
            <form action="{{ route('update_edited_quantity',$stockOut->stock_out_id) }}" method="post">
                  @csrf
                <div class="row">
                    <input type="hidden" name="line_no" value="{{ $stockOut->line_no }}">
                    <input type="hidden" name="receiver_id" value="{{ $stockOut->receiver_id }}">
                    <input type="hidden" name="access_id" value="{{ $stockOut->access_id }}">
                    <input type="hidden" name="size_id" value="{{ $stockOut->size_id }}">
                    <input type="hidden" name="color_id" value="{{ $stockOut->color_id }}">
                    <input type="hidden" name="style_id" value="{{ $stockOut->style_id }}">
                    <div class="col-sm-3">
                        <label class=""><strong>Accessories Name</strong></label>
                        <input class="form-control"readonly placeholder="User Name" value="{{ $stockOut->access_name }}" type="text" name="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><!-- col -->
                    @if ($stockOut->size)
                    <div class="col-sm-3">
                        <label class=""><strong>Size</strong></label>
                        <input class="form-control" readonly  value="{{ $stockOut->size }}" type="text">

                    </div><!-- col -->
                    @endif
                    @if ($stockOut->color_name)
                    <div class="col-sm-3">
                        <label class=""><strong>Color Name</strong></label>
                        <input class="form-control" value="{{ $stockOut->color_name }}" readonly type="text">

                    </div><!-- col -->
                     @endif

                    <div class="col-sm-3">
                        <label class=""><strong>New Quanity</strong></label>
                        <input class="form-control" placeholder="Quanity" value="{{ $stockOut->quantity }}"  type="number" name="quantity">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><!-- col -->

                </div><!-- row -->

                <button class="btn btn-warning mt-3" type="submit">Update</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".select2").select2({
            tags: true
        });
    </script>
@endsection




