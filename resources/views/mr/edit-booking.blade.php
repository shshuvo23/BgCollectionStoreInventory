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
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit Booking</h6>
                </div>
                <div>
                    @include('mr.short_code.backbutton')
                </div>
            </div>
            {{-- {{ $errors }}
            <pre>
                {{ print_r(session()->all()) }}
            </pre> --}}
            <form id="updateBooking" action="{{ route('booking.update', $inventory->id) }}" method="post">
                @csrf()
                @method('put')
                <div class="row">
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Style Number</strong> <span class="text-danger">*</span></label>
                        <select class="form-control is_invalid" id="style_no" name="style_no">
                            <option value="" selected>--Select Style--</option>
                            @foreach ($styles as $style)
                                <option {{ $inventory->style_id == $style->id ? 'selected' : '' }}
                                    value="{{ $style->id }}">
                                    {{ $style->style_no }}</option>
                            @endforeach
                        </select>
                        @error('style_no')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Accessories Name</strong> <span class="text-danger">*</span></label>
                        <select id="accessories_name" class="form-control select2" onchange="getUnit(this.value)"
                            name="accessories_name">
                            <option value="" selected disabled hidden>--Select Accessories--</option>
                            @foreach ($accessories as $accessory)
                                <option {{ $inventory->accessories_id == $accessory->id ? 'selected' : '' }}
                                    value="{{ $accessory->id }}">
                                    {{ $accessory->accessories_name }}</option>
                            @endforeach
                        </select>
                        @error('accessories_name')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Unit</strong> <span class="text-danger">*</span></label>
                        <select id='unit' class='form-control select2' name='unit'>
                            <option value="" selected disabled hidden>--Select Unit--</option>
                            @foreach ($units as $unit)
                                <option id="unitId{{ $unit->id }}" {{ old('unit') == $unit->id ? 'selected' : '' }}
                                    value="{{ $unit->id }}">
                                    {{ $unit->unit }}</option>
                            @endforeach
                        </select>
                        @error('unit')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Bar/Ean Code</strong> </label>
                        <input id="bar_or_ean_code" class="form-control" value="{{ $inventory->bar_or_ean_code }}"
                            placeholder="Enter Bar or Ean Code" type="text" name="bar_or_ean_code">
                        @error('bar_or_ean_code')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Color</strong></label>
                        <select id="color" class="form-control select2" name="color">
                            <option value="" selected>--Select Color--</option>
                            @foreach ($colors as $color)
                                <option {{ $inventory->color_id == $color->id ? 'selected' : '' }}
                                    value="{{ $color->id }}">
                                    {{ $color->color_name }}</option>
                            @endforeach
                        </select>
                        @error('color')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Size</strong> </label>
                        <select id="size" class="form-control select2" name="size">
                            <option value="" selected>--Select Size--</option>
                            @foreach ($sizes as $size)
                                <option {{ $inventory->size_id == $size->id ? 'selected' : '' }}
                                    value="{{ $size->id }}">
                                    {{ $size->size }}</option>
                            @endforeach
                        </select>
                        @error('size')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Garments Quantity</strong> <span class="text-danger">*</span></label>
                        <input onchange="change()" id="garments_quantity" class="form-control" type="number" min="1"
                            value="{{  floatFormater($inventory->garments_quantity)  }}" placeholder="Garments Quantity"
                            name="garments_quantity">
                        @error('garments_quantity')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Consumption</strong> <span class="text-danger">*</span></label>
                        <input id="consumption" onchange="change()" class="form-control"type="number" min="1" step="0.1"
                            value="{{ $inventory->consumption }}" name="consumption">
                        @error('consumption')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Tolerance</strong></label>
                        <div class="input-group">
                            <input name="tolerance" id="tolerance" onchange="change()" type="number" min="1"
                                max="10" class="form-control" value="{{ floatFormater($inventory->tolerance)  }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                        @error('tolerance')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Required Quantity</strong> <span
                                class="text-danger">*</span></label>
                        <input id="requered_quantity" class="form-control"
                            value="{{ $inventory->requered_quantity }}" type="number" name="requered_quantity">
                        @error('requered_quantity')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    {{-- <div class="col-lg-3 col-xs-2 col-sm-2 mb-3 ">
                        <label class=""><strong>Accessories Photo</strong> </label>
                        <input id="accessories_photo" accept=".jpg,.png" onchange="preview(this)" class="form-control"
                            placeholder="Required Quantity" type="file" name="accessories_photo">
                        @error('accessories_name')
                            <span   class="text-danger">{{$message}} </span>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-xs-2 col-sm-2 mb-3 ">
                        <img src="" id="previewPhoto">
                    </div> --}}
                </div>
                <a href="javascript:void(0)" onclick="updateBooking()" class="btn btn-warning mt-3"> {!!updateBtn()!!}</a>
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
            $("#style_no").select2();
            requiredQty();
            // get Unit
            $accessories_id = $('#accessories_name').val();
            getUnit($accessories_id);
        });


        function preview(file) {
            var file = $("input[type=file]").get(0).files;
            if (file) {
                var reader = new FileReader();

                reader.onload = function() {
                    $("#previewPhoto").css({
                        "width": "50px",
                        "height": "50px",
                        "margin-top": "24px"
                    });
                    $("#previewPhoto").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function getUnit(id) {
            ajaxSetup();
            $.ajax({
                type: "post",
                url: '{{ route('unit.get') }}',
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {

                        $('#unit').select2('val', data);
                        $('#unit').attr('disabled', true);
                    } else {
                        $('#unit').select2('val', 0);
                        $('#unit').attr('disabled', false);
                    }
                }
            });
        }

        function succcessAlert(message = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: message,
            })
        }


        function updateBooking() {
            var garments_quantity = $('#garments_quantity').val();
            var requered_quantity = $('#requered_quantity').val();
            confirmData(submitBooking, 'Garments quantity = ' + garments_quantity,
                'Requered quantity =' + requered_quantity);
        }
        var submitBooking = function() {
            $('#unit').attr('disabled', false);
            $('#updateBooking').submit();
        };

        function bookingError(err_msg) {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err_msg,
            });

        }

        function change() {
            requiredQty();
        }

        function requiredQty() {
            var g_qty = $('#garments_quantity').val();
            var composition = $('#consumption').val();
            var tolerance = $('#tolerance').val();
            var total = g_qty * composition;
            var requered_quantity = total + total * (tolerance / 100);
            var rQty = Math.ceil(requered_quantity);
            // alert(requered_quantity);
            $('#requered_quantity').val(rQty);
        }
    </script>
@endsection
