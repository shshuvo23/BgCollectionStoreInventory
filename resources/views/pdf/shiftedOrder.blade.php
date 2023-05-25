<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/BG-Collection-logo-.png') }}">
    <title>Inventory Report</title>
    <style>
.table {
    width: 100%;
    /* border: 1px solid #000000; */
    border-spacing: 0;
}
.table td, .table th {
    font-size: 9px;
    font-weight: bold;
    text-align: center;
    padding: 3px;
    vertical-align: top;
    border-top: 1px solid #000000;
    border-left: 1px solid #000000;
    /* border-right: 1px solid #000000; */
}

.table tr:last-child td {
    color:red;
}


h2 {
    text-transform: uppercase;
}

.text-center {
    font-size: 18px;
    text-align: center;
}

.p-25 {
    padding: 25px;
}

.pr-5 {
    padding-right: 15px;
}

.ml-3 {
    margin-left: 9px;
}

.text-capitalize {
    text-transform: capitalize
}

.text-right {
    text-align: right;
}

.mt-25 {
    margin-top: 25px;
}

.title {
    font-size: 15px;
    font-weight: 600;
    line-height: 25px;
    padding: 5px 20px;
    background: #CFCFCF;
    margin: 0;
}
.text-uppercase {
    text-transform: uppercase;
}
    </style>
</head>

<body>

    <div class="br-pagebody mg-t-5 pd-x-30">

        <div class="br-section-wrapper mt-5">
            <div  class="d-flex justify-content-end  align-items-center mb-4">
                <div>
                    {{-- <a href="{{ route('shit.order') }}" class="btn btn-sm btn-info text-white"><i class="fa fa-download"></i></i><span class="pl-2">Shifted Order</span></a>|
                    <a href="{{ route('download.order') }}" class="btn btn-sm btn-info text-white"><i class="fa fa-download"></i></i><span class="pl-2">Download</span></a>|
                    <a href="{{ route('print.order') }}" class="btn btn-sm btn-primary text-white"><i class="fa fa-print"></i></i><span class="pl-2">Print</span></a>|
                --}}
                @if(auth()->user()->role_id == 6)
                <a href="{{ route('add.order') }}" class="btn btn-sm btn-primary text-white"><i class=""></i><span class="pl-2">Add Order</span></a>
                @endif
                <a href="{{ route('order.management') }}" class="ml-2 btn btn-sm btn-warning     text-white"><i class=""></i><span class="pl-2">Running Orders</span>
                </a>
                </div>
        </div>
            <table class="table" id="datatable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Job No</th>
                    <th scope="col">Buyer Name</th>
                    <th scope="col">Merchandiser</th>
                    <th scope="col">Fabrication</th>
                    <th scope="col">Order No</th>
                    <th scope="col">Order Qty</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($shiftOrders as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->job_no }}</td>
                        <td>{{ $item->buyer_name }}</td>
                        <td>{{ $item->merchandiser }}</td>
                        <td>{{ $item->fabrication }}</td>
                        <td>{{ $item->order_no }}</td>
                        <td>{{ $item->order_qty }}</td>
                        <td>{{ $item->unit_price }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('edit.shifted.order',encrypt($item->id)) }}" style="color:black">
                                <i class="fa fa-pencil-square" style="font-size:20px"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


    </div>



        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                // alert('hello');
                $("#buyerSelect").select2({
                    tags: true
                });
                $("#status").select2({
                    tags: true
                });

            });
            $("#datatable").DataTable();

            function  editModal(){

                // alert('hello');
                // let id = $('#'+'style_no').val();
                // $('#'+'styleSeeder').val(id);
                // document.getElementById('styleSeeder').dispatchEvent(new Event('change'));
            }
        </script>

</body>
</html>


