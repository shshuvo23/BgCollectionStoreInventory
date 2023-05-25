<div class="br-section-wrapper mt-4">
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Booking of <span class="text-info">
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
                            <th scope="col">Accessories</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Color </th>
                            <th scope="col">Size</th>
                            <th scope="col">Bar or Ean Code</th>
                            <th scope="col">G.Qty</th>
                            <th scope="col">Consumption </th>
                            <th scope="col">Tolerance </th>
                            <th scope="col">Req Qty</th>
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
                                <td>{{ $inventory->unit ? $inventory->unit :'N/A' }}</td>
                                <td>{{ $inventory->color_name ?$inventory->color_name  :'N/A'}}</td>
                                <td>{{ $inventory->size ? $inventory->size : 'N/A' }}</td>
                                <td>{{ $inventory->bar_or_ean_code ? $inventory->bar_or_ean_code : 'N/A' }}</td>
                                <td><span class="badge bg-primary">{{ floatFormater($inventory->garments_quantity) }}</span></td>
                                <td><span class="badge bg-secondary">{{ floatFormater($inventory->consumption) }}</span></td>
                                <td><span class="badge bg-info">{{ floatFormater($inventory->tolerance) .'%' }}</span></td>
                                <td><span class="badge bg-success">{{ floatFormater($requered_quantity) }} </span></td>
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
