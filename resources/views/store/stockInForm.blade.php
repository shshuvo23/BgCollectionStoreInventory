<form id="stock_in_form" method="post" action="{{route('stock_in')}}">
    @csrf
    <div class="row mb-4">
        <div class="col-lg">
                <label class="" ><strong>Style Number</strong></label>
                <select class="form-control select2" onchange="getInventory()" id="style_no" name="style_no" required>
                    <option value="" selected >--Select Style--</option>
                    @foreach ($styles as $style)
                        <option value="{{$style->id}}">{{$style->style_no}}</option>
                    @endforeach
                </select>
                <span id="style_no_error" class="text-danger"></span>
            {{-- <input class="form-control" placeholder=""  type="text"> --}}
        </div><!-- col -->

        <div class="col-lg">
            <label class="" ><strong>Accessories Name</strong></label>
                <select onchange="selectUnit()" class="form-control select2" id="accessories_name" name="accessories_name" required>
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
            <select class="form-control select2"  id="color_name" name="color_name">
            <option value="" selected >--Select Color--</option>
            @foreach ($colors as $color)
                <option value="{{$color->id}}">{{$color->color_name}}</option>
            @endforeach
        </select>
        <span id="color_name_error" class="text-danger"></span>
        </div><!-- col -->

        <div class="col-lg mg-t-10 mg-lg-t-0">
            <label class="" ><strong>Size</strong></label>
            <select class="form-control select2" id="size" name="size">
                <option value="" selected >--Select Size--</option>
                @foreach ($sizes as $size)
                    <option value="{{$size->id}}">{{$size->size}}</option>
                @endforeach
            </select>
            <span id="size_error" class="text-danger"></span>
        </div><!-- col -->

        <div class="col-lg">
            <label class=""><strong>Challan No</strong></label>
            <select class="form-control select22" id="size" name="size">
                <option value="" selected >--Select Challan--</option>
                @foreach ($challans as $challan)
                    <option value="{{$challan->callan_no}}">{{$challan->callan_no}}</option>
                @endforeach
            </select>
            {{-- <input class="form-control" placeholder="Challan No" type="text" id="callan_no" name="callan_no" required>
            <span id="callan_no_error" class="text-danger"></span> --}}
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
