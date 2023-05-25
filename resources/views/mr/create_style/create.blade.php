@php
    $dashboard = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="mb-3 d-flex justify-content-between">
                <div>
                    @if ($isOrderCreate==0)
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Add Style</h6>
                    @else
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Add Order</h6>
                    @endif
                </div>
                <div>
                    @if ($isOrderCreate==0)
                    <a class="btn btn-warning" href="{{ route('dashboard') }}"><i class="fa fa-plus"></i> Booking</a>
                    @else
                    <a class="btn btn-warning" href="{{ route('order_list_for_booking') }}"><i class="fa fa-plus"></i> Yarn Booking</a>
                    @endif
                </div>
            </div>
            <form action="{{ route('style.store') }}" method="POST">
                @csrf
                <input type="text" hidden value="{{$isOrderCreate}}" name="isOrderCreate">
                <div class="row">
                    <div class="{{ $isOrderCreate==1?'col-lg-6 col-md-6':'col-lg-4 col-md-4' }}">
                        <label class=""><strong>Buyer Name</strong> <span class="text-danger">*</span></label>
                        <select id="buyerId" class="select2 form-control" name="buyer_name">
                            <option value="" selected>--Select Buyer--</option>
                            @foreach ($buyers as $buyer)
                                <option value="{{ $buyer->id }}">{{ $buyer->buyer_name }}</option>
                            @endforeach
                        </select>
                        @error('buyer_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="{{ $isOrderCreate==1?'col-lg-6 col-md-6':'col-lg-4 col-md-4' }}">
                        <label class=""><strong>Order Number</strong> <span class="text-danger">*</span></label>
                        @if(!$isOrderCreate==1)
                            <select id="orderId" class="select2  form-control" name="order_no">
                                {{-- data add form get_order() --}}
                            </select>
                        @else
                            <select  class="select2 form-control" name="order_no">
                                <option value="" selected>--Select Order--</option>
                            </select>
                        @endif
                        @error('order_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if(!$isOrderCreate==1)
                    <div class="col-lg-4 col-md-4">
                        <label class=""><strong>Style Number</strong> <span class="text-danger">*</span></label>
                        <select id="styleId" class="select2  form-control" name="style_no">
                            {{-- data add form get_order() --}}
                        </select>
                        {{-- <input class="form-control" placeholder="Enter New Style" type="text" name="style_no"> --}}
                        @error('style_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif

                </div>
                <button class="btn btn-primary mt-3" type="submit"> {!!submitBtn()!!}</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                tags: true
            });
            var buyer_id = $('#buyerId').val();
            get_order(buyer_id);
            get_style();


            function ajaxSetup() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            $('#buyerId').change(function() {
                var buyer_id = $(this).val();
                get_order(buyer_id);
            });

            function get_order(buyer_id) {
                ajaxSetup();
                $.ajax({
                    type: "post",
                    url: '{{ route('orders.get') }}',
                    data: {
                        buyer_id: buyer_id
                    },
                    success: function(results) {
                        $('#orderId').html(results)
                    }
                });
            }

            function get_style() {
                $.ajax({
                    type: "get",
                    url: '{{ route('style.get') }}',
                    success: function(results) {
                        $('#styleId').html(results)
                    }
                });
            }
        });
    </script>
@endsection
