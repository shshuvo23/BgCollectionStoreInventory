@php
    $users_menu =true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            {{-- <div class="d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit Accessories Of {{ $stockOut->access_name }}</h6>
                </div>
            </div> --}}
            @php

            @endphp
            <form action="{{ route('update_stockout_info_history',$stockOut->id) }}" method="post">
                  @csrf
                <div class="row">

                    <div class="col-sm-6">
                        <label class=""><strong>Receiver Name</strong></label>
                        <select class="form-control" id="receviers" name="receiver">
                            <option value="" selected disabled hidden>--Select Receiver--</option>
                         @foreach ($receivers as $receiver)
                            <option value="{{ $receiver->id }}" {{ $receiver->id == $stockOut->receiver_id?"selected":"" }}>{{ $receiver->receiver_name }}</option>
                            @endforeach
                            @error('receiver_id')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror
                        </select>
                    </div><!-- col -->

                    <div class="col-sm-6">
                        <label class=""><strong>Line No</strong></label>
                        <input class="form-control"  name="line_no" value="{{ $stockOut->line_no }}" type="text">

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
        $(document).ready(function() {
            $("#receviers").select2({
                tags:true
            });
        });
    </script>
@endsection




