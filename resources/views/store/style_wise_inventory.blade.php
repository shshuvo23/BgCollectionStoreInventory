<div class="br-section-wrapper mt-4">
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Inventory of <span class="text-info">
                    {{ $style->style_no }}</span></h3>
        </div>
    </div>
    <div id="booking_info">
        <div id="stock_in_section"  class="table-responsive">
            @if ($inventories->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Accessories Name</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Color Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Garments Quantity</th>
                            <th scope="col">Requered Quantity</th>
                            <th scope="col">Received Quantity</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Stock Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                        @php
                            $requered_quantity =  $inventory->requered_quantity;
                            $received_quantity =  $inventory->received_quantity;
                            $balance =   $received_quantity  - $requered_quantity;
                            $stock_quantity =  $inventory->stock_quantity ;
                        @endphp
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $inventory->accessories_name }}</td>
                                <td>{{ $inventory->unit }}</td>
                                <td>{{ $inventory->color_name }}</td>
                                <td>{{ $inventory->size }}</td>
                                <td>{{ floatFormater($inventory->garments_quantity) }}</td>
                                <td>{{ floatFormater($requered_quantity) }}</td>
                                <td><span class="badge bg-{{ $received_quantity >= $requered_quantity ? 'secondary' : 'danger' }} ">{{ floatFormater($received_quantity) }} </span></td>

                                <td> <span class="badge bg-{{ $balance > 0 ? 'info' : 'danger' }} ">{{ floatFormater($balance) }} </span></td>
                                <td> <span class="badge bg-{{ $stock_quantity > 0 ? 'success' : 'warning' }} ">{{ floatFormater($stock_quantity) }} </span></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <h5 class="text-center text-danger text-capitalize mt-4 "> booking or inventory not found</h5>
            @endif

        </div>
    </div>
</div>



