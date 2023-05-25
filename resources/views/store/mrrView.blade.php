@php
    $mr_list = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-5">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Store Stock In Entry</h6>
            <p class="mg-b-25 mg-lg-b-50">Store Stock In Entry form</p>
            <div id="">
                <form  method="post" action="{{route('mrr_update', Crypt::encrypt($mrr->id))}}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-lg">
                                <label class="" ><strong>Style Number</strong></label>
                                <select class="form-control select2" id="style_no" name="style_no" required {{$isStockout ? '' : ''}} >
                                    <option value="" selected disabled hidden>--Select Style--</option>
                                    @foreach ($styles as $style)
                                        <option value="{{$style->id}}" {{$style->id == $mrr->style_id ? 'selected' : ''}}>{{$style->style_no .' ('. $style->buyer_name .')' }}</option>
                                    @endforeach
                                </select>
                                <span id="style_no_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class="" ><strong>Accessories Name</strong></label>
                                <select onchange="selectUnit()" class="form-control select2" id="accessories_name" name="accessories_name" {{$isStockout ? '' : ''}} required>
                                    <option value="" selected disabled hidden>--Select Accessories--</option>
                                    @foreach ($accessories as $accessory)
                                        <option value="{{$accessory->id}}" {{$accessory->id == $mrr->accessories_id ? 'selected' : ''}} >{{$accessory->accessories_name}}</option>
                                    @endforeach
                                </select>
                                <span id="accessories_name_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class="" ><strong>Unit</strong></label>
                                <select class="form-control select2" id="unit" name="unit" readonly="" {{$isStockout ? '' : ''}} required>
                                    <option value="0" selected disabled hidden>--Select Unit--</option>
                                    @foreach ($units as $unit)
                                        <option id="{{$unit->id}}" value="{{$unit->id}}" {{$unit->id == $accessory->unit_id ? 'selected' : ''}}>{{$unit->unit}}</option>
                                    @endforeach
                                </select>
                                <span id="unit_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->



                        <div class="col-lg">
                            <label class=""><strong>Supliers</strong></label>
                                <select class="form-control select22" id="supplier_name" name="supplier_name" required>
                                    <option value="" selected disabled hidden>--Select Suppliers--</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" {{$supplier->id == $mrr->supplier_id ? 'selected' : ''}}>{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </select>
                                <span id="supplier_name_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                    </div><!-- row -->
                    <div class="row mb-4">

                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <label class="" ><strong>Color</strong></label>
                            <select class="form-control select2"  id="color_name" name="color_name" {{$isStockout ? '' : ''}}>
                            <option value="" selected disabled hidden>--Select Color--</option>
                            @foreach ($colors as $color)
                                <option value="{{$color->id}}" {{$color->id == $mrr->color_id ? 'selected' : ''}}>{{$color->color_name}}</option>
                            @endforeach
                        </select>
                        <span id="color_name_error" class="text-danger"></span>
                        </div><!-- col -->

                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <label class="" ><strong>Size</strong></label>
                            <select class="form-control select2" id="size" name="size" {{$isStockout ? '' : ''}}>
                                <option value="" selected >--Select Size--</option>
                                @foreach ($sizes as $size)
                                    <option value="{{$size->id}}" {{$size->id == $mrr->size_id ? 'selected' : ''}}>{{$size->size}}</option>
                                @endforeach
                            </select>
                            <span id="size_error" class="text-danger"></span>
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>Challan No</strong></label>
                            {{-- <input class="form-control" placeholder="Challan No" type="text" id="callan_no" name="callan_no" value="{{$mrr->callan_no}}" required> --}}
                            <select class="form-control select22" id="callan_no" name="callan_no">
                                <option value="" selected >--Select Challan--</option>
                                @foreach ($challans as $challan)
                                    <option value="{{$challan->callan_no}}" {{$challan->id == $mrr->callan_id ? 'selected' : ''}}>{{$challan->callan_no}}</option>
                                @endforeach
                            </select>
                            <span id="callan_no_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>MRR</strong></label>
                            <input class="form-control" placeholder="MRR No" type="text" id="mrr_no" name="mrr_no" value="{{$mrr->mrr_no}}" required>
                            <span id="mrr_no_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->
                    </div><!-- row -->

                    <div class="row mb-4">
                        <div class="col-lg">
                            <label class=""><strong>Recived Date</strong></label>
                            <input class="form-control"  type="date" id="received_date" name="received_date" value="{{$mrr->received_date}}" required>
                            <span id="received_date_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>Collected By</strong></label>
                            <input class="form-control" placeholder="Collected By" type="text" id="collected_by" name="collected_by" value="{{$mrr->collected_by}}" required>
                            <span id="collected_by_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>Received Quanity</strong></label>
                            <input class="form-control" placeholder="Quantity" type="number" id="quantity" name="quantity" onchange="onlyPositive('quantity',0)"  value="{{floatFormater($mrr->quantity)}}" required>
                            <span id="quantity_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->


                    </div><!-- row -->
                    {{-- <button type="submit">sub</button> --}}
                    {{-- <a href="javascript:void(0)"  class="btn btn-primary mt-3" id="stockIn">Update</a> --}}
                    <button type="submit" class="btn btn-warning mt-3">Update</button>
                </form>

            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".select2").select2({
                tags: false
            });
            $(".select22").select2({
                tags: true
            });
        });
    </script>




    <script>
        function selectUnit() {

            let accessory = $('#accessories_name').val();

            $.get('{{ route('get_single_unit') }}', {
                accessory: accessory
            }, function(data) {

                if (data == 0) {
                    document.getElementById("unit").disabled = false;
                    document.getElementById("unit").selectedIndex = 0;
                    $("#unit").select2("val", "0");
                } else {
                    $("#unit").select2("val", data);
                    document.getElementById("unit").disabled = true;
                }
            });
        }
    </script>

    @endsection
