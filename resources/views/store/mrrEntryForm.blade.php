
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="br-pagebody  pd-x-30">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Store Stock In Entry</h6>
            <p class="mg-b-25 mg-lg-b-50">Store Stock In Entry form</p>
            <div id="stock_in_section">
                <form id="stock_in_form" method="post" action="{{route('stock_in')}}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-lg">
                                <label class="" ><strong>Style Number</strong></label>
                                <select class="form-control select2" onchange="getInventory()" id="style_no" name="style_no" required>
                                    <option value="" selected >--Select Style--</option>
                                    @foreach ($styles as $style)
                                        <option value="{{$style->id}}">{{$style->style_no .' ('. $style->buyer_name .')' }}</option>
                                    @endforeach
                                </select>
                                <span id="style_no_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class="" ><strong>Accessories Name</strong></label>
                                <select onchange="changeAccessories()" class="form-control select2" id="accessories_name" name="accessories_name" required>
                                    <option value="" selected >--Select Accessories--</option>
                                    @foreach ($accessories as $accessory)
                                        <option value="{{$accessory->id}}">{{$accessory->accessories_name}}</option>
                                    @endforeach
                                </select>
                                <span id="accessories_name_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class="" ><strong>Unit</strong></label>
                                <select class="form-control select2" id="unit" name="unit" readonly="" required>
                                    <option value="0" selected >--Select Unit--</option>
                                    @foreach ($units as $unit)
                                        <option id="{{$unit->id}}" value="{{$unit->id}}">{{$unit->unit}}</option>
                                    @endforeach
                                </select>
                                <span id="unit_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->



                        <div class="col-lg">
                            <label class=""><strong>Supliers</strong></label>
                                <select class="form-control select22" id="supplier_name" name="supplier_name" required>
                                    <option value="" selected >--Select Suppliers--</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </select>
                                <span id="supplier_name_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                    </div><!-- row -->
                    <div class="row mb-4">

                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <label class="" ><strong>Color</strong></label>
                            <select onchange="getInventory()" class="form-control select2"  id="color_name" name="color_name">
                                <option value="" selected >--Select Color--</option>
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}">{{$color->color_name}}</option>
                                @endforeach
                            </select>
                        <span id="color_name_error" class="text-danger"></span>
                        </div><!-- col -->

                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <label class="" ><strong>Size</strong></label>
                            <select onchange="getInventory()" class="form-control select2" id="size" name="size">
                                <option value="" selected >--Select Size--</option>
                                @foreach ($sizes as $size)
                                    <option value="{{$size->id}}">{{$size->size}}</option>
                                @endforeach
                            </select>
                            <span id="size_error" class="text-danger"></span>
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>Challan No</strong></label>
                            <select class="form-control select22" id="callan_no" name="callan_no">
                                <option value="" selected >--Select Challan--</option>
                                @foreach ($challans as $challan)
                                    <option value="{{$challan->callan_no}}">{{$challan->callan_no}}</option>
                                @endforeach
                            </select>
                            <span id="callan_no_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder="Challan No" type="text" id="callan_no" name="callan_no" required> --}}
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>MRR</strong></label>
                            <input class="form-control" placeholder="MRR No" type="text" id="mrr_no" name="mrr_no" required>
                            <span id="mrr_no_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->
                    </div><!-- row -->

                    <div class="row mb-4">
                        <div class="col-lg">
                            <label class=""><strong>Recived Date</strong></label>
                            <input class="form-control"  type="date" id="received_date" name="received_date" required>
                            <span id="received_date_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>Collected By</strong></label>
                            <input class="form-control" placeholder="Collected By" type="text" id="collected_by" name="collected_by" required>
                            <span id="collected_by_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->

                        <div class="col-lg">
                            <label class=""><strong>Received Quanity</strong></label>
                            <input class="form-control" placeholder="Quantity" type="number" id="quantity" name="quantity" onchange="onlyPositive('quantity')" required>
                            <span id="quantity_error" class="text-danger"></span>
                            {{-- <input class="form-control" placeholder=""  type="text"> --}}
                        </div><!-- col -->


                    </div><!-- row -->
                    {{-- <button type="submit">sub</button> --}}
                    <a href="javascript:void(0)" onclick="stockIn()" class="btn btn-primary mt-3" id="stockIn">Stock In Accessories</a>
                </form>
            </div>
        </div>
        <div id="booking-list">

        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
            function getInventory(){
                var style_id = $('#style_no').val();
                var accessories_id = $('#accessories_name').val();
                var color_id = $('#color_name').val();
                var size_id = $('#size').val();

                console.log(style_id+" "+accessories_id+" "+color_id+" "+size_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: '{{ route('inventory_get') }}',
                    data: {
                        style_id: style_id,
                        accessories_id:accessories_id,
                        color_id:color_id,
                        size_id:size_id,
                    },
                    success: function(results) {
                        // console.log(results);
                        $('#booking-list').html(results);
                    },
                });
            }
        </script>

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
            function changeAccessories(){
                selectUnit();
                getInventory();
            }
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

        <script>
            function stockIn() {
                let data = {};
                let frontEndvalidation = true;
                $("#stock_in_form :input").each(function() {
                    if($(this).attr("name").length > 0){
                        let Id = $(this).attr("id") + '_error';
                        if (Id != "undefined_error") document.getElementById(Id).innerHTML = "";
                        let required = $(this).attr("required");
                        if (required == "required" && ($(this).val() == "" || $(this).val() == null)) {
                            if (frontEndvalidation) {
                                if (Id != "undefined_error") document.getElementById(Id).innerHTML =
                                    "This field is required";
                                frontEndvalidation = false;
                            }
                        } else {
                            data[$(this).attr("name")] = $(this).val();
                        }
                    }
                });
                if (frontEndvalidation) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    Swal.fire({
                        title: 'Are you sure?',
                        html: "<h2 class='text-danger'>Received quantity = "+ $('#quantity').val() +"</h2>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post('{{ route('stock_in') }}',{
                                data: data
                            }, function(data) {
                                let arr = Object.entries(data);

                                if (arr[0][0] == "error" || arr[0][0] == "success") {
                                    getInventory();

                                        if(arr[0][0] == "success")success('Successfully Inserted');
                                        if(arr[0][0] == "error"){
                                            ;
                                            Swal.fire(
                                                'Warning!',
                                                arr[0][1],
                                                'warning'
                                            );
                                        }
                                } else {
                                    for (let index = 0; index < arr.length; ++index) {
                                        let element = arr[index];
                                        if (element[0] != "error" && element[0] != 'success')
                                            document.getElementById(element[0] + '_error').innerHTML = element[1];
                                    }
                                }

                            });
                        }
                    });
                }
            }
        </script>
    @endsection
