@php
    $search_booking = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div id="booking-list">
            <div id="booking_info">
                <div class="br-section-wrapper mt-4">
                    <div class="d-flex justify-content-between  mb-3">
                        <div>
                            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 ">Search style wise Inventory </h6>
                        </div>
                        <div>
                            @if ($inventories)
                                <a href="{{ route('download.inventory', Crypt::encrypt($style_id)) }}"
                                    class="btn btn-primary mr-3"><i class="fa fa-download "></i> Download </a>
                                <a href="{{ route('print.inventory', Crypt::encrypt($style_id)) }}"
                                    class="btn btn-secondary mr-3"><i class="fa fa-print "></i> Print </a>
                            @endif
                            @include('mr.short_code.backbutton')
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                            <select class="form-control is_invalid" id="style_no" onchange="redirect()" name="style_no">
                                <option value="" selected>--Select Style--</option>
                                @foreach ($styles as $style)
                                    <option {{ $style_id == $style->id ? 'selected' : '' }}
                                        value="{{ Crypt::encrypt($style->id) }}">
                                        {{ $style->style_no . ' (' .$style->order_no .' , '. $style->buyer_name . ')' . ' '.$style->created_at->format('My')   }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="booking_info">
                        <div id="stock_in_section" class="table-responsive" style="overflow-y: hidden">
                            @if ($inventories == false)
                                <h5 class="text-center text-info mt-4 "> Please select a style </h5>
                            @elseif ($inventories->count() > 0)
                                <table class="table table-hover" id="dataTable">
                                    @php
                                        $createdBy = null;
                                    @endphp
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Bar Code </th>
                                            <th scope="col"> G.Qty + CONS + tol </th>
                                            <th scope="col">Req Qty</th>
                                            <th scope="col">Rec Qty</th>
                                            <th scope="col">Balance</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Stock Out</th>
                                            @if ((auth()->user()->role_id == 2 && auth()->user()->id == $createdBy) or (auth()->user()->role_id==6 or auth()->user()->role_id==3))
                                            <th scope="col">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventories as $inventory)
                                            @php
                                                $requered_quantity = floatFormater($inventory->requered_quantity);
                                                $received_quantity = floatFormater($inventory->received_quantity);
                                                $bar_or_ean_code = $inventory->bar_or_ean_code ? $inventory->bar_or_ean_code : 'N/A';
                                                $balance = floatFormater($received_quantity - $requered_quantity);
                                                $stock_quantity = floatFormater($inventory->stock_quantity);
                                                $stock_out = floatFormater($received_quantity - $stock_quantity);
                                                $consumption = floatFormater($inventory->consumption);
                                                $tolerance = floatFormater($inventory->tolerance);
                                                $garments_quantity = floatFormater($inventory->garments_quantity);
                                                $createdBy = $inventory->created_by;
                                            @endphp

                                            <tr
                                                @if (in_array($inventory->id, $effected_inventory_ids)) style="background:#a9abac;color:#fff;" @endif>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $inventory->accessories_name }}</td>
                                                <td>{{ $inventory->unit }}</td>
                                                <td>{{ $inventory->color_name }}</td>
                                                <td>{{ $inventory->size }}</td>
                                                <td> {{ $inventory->bar_or_ean_code ? $inventory->bar_or_ean_code : 'N/A' }}
                                                </td>
                                                <td> {{ '(' . $garments_quantity . 'x' . $consumption . ') +' . $tolerance . '%' }}
                                                </td>
                                                <td>{{ $requered_quantity }}</td>
                                                <td><span
                                                        class="badge bg-{{ $received_quantity >= $requered_quantity ? 'secondary' : 'danger' }} ">{{ $received_quantity }}
                                                    </span></td>

                                                <td> <span
                                                        class="badge bg-{{ $balance > 0 ? 'info' : 'danger' }} ">{{ $balance }}
                                                    </span></td>
                                                <td> <span
                                                        class="badge bg-{{ $stock_quantity > 0 ? 'success' : 'warning' }} ">{{ $stock_quantity }}
                                                    </span></td>
                                                <td> <span
                                                        class="badge bg-{{ $stock_out > 0 ? 'primary' : 'secondary' }} ">{{ $stock_out }}
                                                    </span></td>
                                                <td>
                                                    @include('action_button.inventory_action')
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h5 class="text-center text-danger text-capitalize mt-4 "> booking or inventory not found
                                </h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        if ($notification) {
            $notification->effected_accessories = 0;
            $notification->effected_inventory_ids = '';
            $notification->timestamps = false;
            $notification->save();
        }
    @endphp
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#style_no").select2();
        });

        function redirect() {
            var style_no = $('#style_no').val();
            window.location.href = "{{ route('inventory.list') }}" + '/' + style_no;
            $(window).hide(0).delay(4000).slideDown(5000);
        }
    </script>
@endsection
