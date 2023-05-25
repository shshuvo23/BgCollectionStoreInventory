

<table class="table table-hover" id="dataTable">
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
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventories as $inventory)
            @php
                $requered_quantity = $inventory->requered_quantity ?? 0;
                $received_quantity = $inventory->received_quantity ?? 0;
                $bar_or_ean_code = $inventory->bar_or_ean_code ? $inventory->bar_or_ean_code : 'N/A';
                $balance = $received_quantity - $requered_quantity;
                $stock_quantity = $inventory->stock_quantity ?? 0;
                $stock_out = $received_quantity - $stock_quantity;
                $consumption = $inventory->consumption ?? 1;
                $tolerance = $inventory->tolerance ?? 0;
                $garments_quantity = $inventory->garments_quantity ?? 0;
            @endphp
            <tr>
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
                        class="badge bg-{{ $stock_out > 0 ? 'primary' : 'secondary' }} ">{{ $stock_quantity }}
                    </span></td>
                <td>
                    <div class="dropdown show">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Histories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a  onclick="setSession('back', 1, '{{ route('boking_histories', Crypt::encrypt($inventory->id) ) }}')" href="javascript:void(0)" class="dropdown-item">Booking History</a>
                            <a  onclick="setSession('back', 1, '{{ route('stock_histories', Crypt::encrypt($inventory->id) ) }}')"  href="javascript:void(0)" class="dropdown-item">Stock History</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>




{{-- <table id="indentory-table" class="table table-hover">
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
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($inventories as $inventory)
        <tr>
            <th scope="row">{{$loop->index+1}}</th>
            <td>{{$inventory->accessories_name}}</td>
            <td>{{$inventory->unit}}</td>
            <td>{{$inventory->color_name}}</td>
            <td>{{$inventory->size}}</td>
            <td>{{$inventory->garments_quantity ??  0}}</td>
            <td>{{$inventory->requered_quantity ?? 0}}</td>
            <td>{{$inventory->received_quantity ?? 0}}</td>
            <td>{{($inventory->received_quantity ?? 0) - ($inventory->requered_quantity ?? 0)}}</td>
            <td>{{$inventory->stock_quantity ?? 0}}</td>
            <td>
                <div class="dropdown show">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Histories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a  onclick="setSession('back', 1, '{{ route('boking_histories', Crypt::encrypt($inventory->id) ) }}')" href="javascript:void(0)" class="dropdown-item">Booking History</a>
                        <a  onclick="setSession('back', 1, '{{ route('stock_histories', Crypt::encrypt($inventory->id) ) }}')"  href="javascript:void(0)" class="dropdown-item">Stock History</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> --}}


