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
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Booking </h6>
                    <p class="mg-b-25 mg-lg-b-50">Booking Accessories</p>
                </div>
                <div>
                    <a class="btn btn-warning" href="{{ route('style.create') }}"><i class="fa fa-plus"></i> Add Style</a>
                </div>
            </div>
            <form id="bookingForm">
                <div class="row">
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Style Number </strong> <span class="text-danger">*</span></label>
                        <select class="form-control is_invalid" id="style_no" name="style_no" onchange="getInventory()">
                            <option value="" selected>--Select Style--</option>
                            @foreach ($styles as $style)

                                <option {{ old('style_no') == $style->id ? 'selected' : '' }} value="{{ $style->id }}">
                                    {{ $style->style_no . ' (' .$style->order_no .' , '. $style->buyer_name . ')' . ' '.$style->created_at->format('My')   }} </option>
                            @endforeach
                        </select>
                        <span id="styleNoError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Accessories Name</strong> <span class="text-danger">*</span></label>
                        <select id="accessories_name" class="form-control select2" onchange="getUnit(this.value)"
                            name="accessories_name">
                            <option value="" selected disabled hidden>--Select Accessories--</option>
                            @foreach ($accessories as $accessory)
                                <option {{ old('accessories_name') == $accessory->id ? 'selected' : '' }}
                                    value="{{ $accessory->id }}">
                                    {{ $accessory->accessories_name }}</option>
                            @endforeach
                        </select>
                        <span id="accessoriesNameError" class="text-danger"> </span>
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
                        <span id="unitError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Bar/Ean Code</strong> </label>
                        <input id="bar_or_ean_code" class="form-control" value="{{ old('bar_or_ean_code') }}"
                            placeholder="Enter Bar or Ean Code" type="text" name="bar_or_ean_code">
                        <span id="barOrEanCodeError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Color</strong></label>
                        <select id="color" class="form-control select2" name="color">
                            <option value="" selected>--Select Color--</option>
                            @foreach ($colors as $color)
                                <option {{ old('color') == $color->id ? 'selected' : '' }} value="{{ $color->id }}">
                                    {{ $color->color_name }}</option>
                            @endforeach
                        </select>
                        <span id="colorError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-4 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Size</strong> </label>
                        <select id="size" class="form-control select2" name="size">
                            <option value="" selected>--Select Size--</option>
                            @foreach ($sizes as $size)
                                <option {{ old('size') == $size->id ? 'selected' : '' }} value="{{ $size->id }}">
                                    {{ $size->size }}</option>
                            @endforeach
                        </select>
                        <span id="sizeError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Garments Quantity</strong> <span class="text-danger">*</span></label>
                        <input onchange="change()" id="garments_quantity" class="form-control" type="number" min="1"
                            value="{{ old('garments_quantity') ? old('garments_quantity') : 1 }}"
                            placeholder="Garments Quantity" name="garments_quantity">
                        <span id="garmentsQuantityError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Consumption</strong> <span class="text-danger">*</span></label>
                        <input id="consumption" onchange="change()" class="form-control"type="number" min="0" step="0.1"
                            value="{{ old('consumption') ? old('consumption') : 1 }}" name="consumption">
                        <span id="consumptionError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Tolerance</strong></label>
                        <div class="input-group">
                            <input id="tolerance" onchange="change()" type="number" min="1" max="20"
                                class="form-control" value="{{ old('tolerance') ? old('tolerance') : 1 }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                        <span id="toleranceError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-3 col-xs-6 col-sm-6 mb-3 ">
                        <label class=""><strong>Required Quantity</strong> <span
                                class="text-danger">*</span></label>
                        <input id="requered_quantity"  class="form-control"
                            value="{{ old('requered_quantity') }}" type="number" name="requered_quantity">
                        <span id="requeredQuantityError" class="text-danger"> </span>
                    </div>
                    {{-- <div class="col-lg-3 col-xs-2 col-sm-2 mb-3 ">
                        <label class=""><strong>Accessories Photo</strong> </label>
                        <input id="accessories_photo" accept=".jpg,.png" onchange="preview(this)" class="form-control"
                            placeholder="Required Quantity" type="file" name="accessories_photo">
                        <span id="accessoriesPhotoError" class="text-danger"> </span>
                    </div>
                    <div class="col-lg-3 col-xs-2 col-sm-2 mb-3 ">
                        <img src="" id="previewPhoto">
                    </div> --}}
                </div>
                <a href="javascript:void(0)" onclick="confirmBooking()" id="submitBooking" class="btn btn-primary mt-3"
                    type="submit">{!! submitBtn() !!}</a>
            </form>
        </div>
        <div id="booking-list">

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
            if ($('#style_no').val()) {
                getInventory();
            }
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

        // $('#accessories_name').change(function() {
        //     var id = $(this).val();
        //     getUnit(id);
        // });
        // success alert
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

        // booking
        // $('#submitBooking').click(function() {
        //     $('#unit_id').attr('disabled', false);
        //     var garments_quantity = $('#garments_quantity').val();
        //     var requered_quantity = $('#requered_quantity').val();
        //     confirmData(submitBooking(), 'Garments quantity = ' + garments_quantity,
        //         'Requered quantity =' + requered_quantity);
        // });
        function confirmBooking() {
            $('#unit_id').attr('disabled', false);
            var garments_quantity = $('#garments_quantity').val();
            var requered_quantity = $('#requered_quantity').val();
            confirmData(submitBooking, 'Garments quantity = ' + garments_quantity,
                'Requered quantity =' + requered_quantity);
        }

        var submitBooking = function() {
            var style_no = $('#style_no').val();
            var accessories_name = $('#accessories_name').val();
            var unit = $('#unit').val();
            var color = $('#color').val();
            var size = $('#size').val();
            var garments_quantity = $('#garments_quantity').val();
            var requered_quantity = $('#requered_quantity').val();
            // new
            var bar_or_ean_code = $('#bar_or_ean_code').val();
            var consumption = $('#consumption').val();
            var tolerance = $('#tolerance').val();

            ajaxSetup();
            $.ajax({
                type: "post",
                url: '{{ route('booking.store') }}',
                data: {
                    style_no: style_no,
                    accessories_name: accessories_name,
                    unit: unit,
                    color: color,
                    size: size,
                    garments_quantity: garments_quantity,
                    requered_quantity: requered_quantity,
                    // new
                    bar_or_ean_code: bar_or_ean_code,
                    consumption: consumption,
                    tolerance: tolerance,

                },
                success: function(results) {
                    if (results.success) {
                        succcessAlert('Booking success');
                        getInventory();
                    }
                    if (results.error) {
                        bookingError(results.error);
                    }
                    $('#style_no').removeClass('is-invalid');
                    $('#styleNoError').html('');
                    $('#accessories_name').removeClass('is-invalid');
                    $('#accessoriesNameError').html('');
                    $('#unit').removeClass('is-invalid');
                    $('#unitError').html('');
                    $('#color').removeClass('is-invalid');
                    $('#colorError').html('');
                    $('#size').removeClass('is-invalid');
                    $('#sizeError').html('');
                    $('#garments_quantity').removeClass('is-invalid');
                    $('#garmentsQuantityError').html('');
                    $('#requered_quantity').removeClass('is-invalid');
                    $('#requeredQuantityError').html('');
                    // new validation
                    $('#bar_or_ean_code').removeClass('is-invalid');
                    $('#barOrEanCodeError').html('');
                    $('#consumption').removeClass('is-invalid');
                    $('#consumptionError').html('');
                    $('#tolerance').removeClass('is-invalid');
                    $('#toleranceError').html('');

                    if (results.style_no) {
                        $('#style_no').addClass('is-invalid');
                        $('#styleNoError').html(results.style_no);
                    }
                    if (results.accessories_name) {
                        $('#accessories_name').addClass('is-invalid');
                        $('#accessoriesNameError').html(results.accessories_name);
                    }
                    if (results.unit) {
                        $('#unit').addClass('is-invalid');
                        $('#unitError').html(results.unit);
                    }
                    if (results.color) {
                        $('#color').addClass('is-invalid');
                        $('#colorError').html(results.color);
                    }
                    if (results.size) {
                        $('#size').addClass('is-invalid');
                        $('#sizeError').html(results.size);
                    }
                    if (results.garments_quantity) {
                        $('#garments_quantity').addClass('is-invalid');
                        $('#garmentsQuantityError').html(results.garments_quantity);
                    }
                    if (results.requered_quantity) {
                        $('#requered_quantity').addClass('is-invalid');
                        $('#requeredQuantityError').html(results.requered_quantity);
                    }
                    // new
                    if (results.bar_or_ean_code) {
                        $('#bar_or_ean_code').addClass('is-invalid');
                        $('#barOrEanCodeError').html(results.bar_or_ean_code);
                    }
                    if (results.consumption) {
                        $('#consumption').addClass('is-invalid');
                        $('#consumptionError').html(results.consumption);
                    }
                    if (results.tolerance) {
                        $('#tolerance').addClass('is-invalid');
                        $('#toleranceError').html(results.tolerance);
                    }
                },
            });
        }
        // $("#style_no").change(function() {
        //     getInventory();
        // });

        function getInventory() {
            var style_id = $('#style_no').val();
            ajaxSetup();
            $.ajax({
                type: "post",
                url: '{{ route('inventory.get') }}',
                data: {
                    style_id: style_id,
                },
                success: function(results) {
                    $('#booking-list').html(results);
                    $()
                },
            });
        }

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
