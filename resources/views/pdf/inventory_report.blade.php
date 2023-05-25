<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/BG-Collection-logo-.png') }}">
    <title>Inventory Report</title>
    <style>
        table.table {
            border: 0px solid #000000;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        table.table td,
        table.table th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }

        table.table tbody td {
            font-size: 13px;
        }

        .table-header {
            background: #CFCFCF;
            border-bottom: 2px solid #000000;
        }

        table.table thead th {
            font-size: 13px;
            font-weight: bold;
            color: #000000;
            text-align: center;

        }

        table.table tfoot td {
            font-size: 14px;
        }

        h2 {
            text-transform: uppercase;
        }

        .text-center {
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
            font-size: 20px;
            font-weight: 600;
            line-height: 25px;
            padding: 10px 20px;
            background: #CFCFCF;
            margin: 0;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <table class="table mt-25">
        <thead>
            <tr style="border-top: 2px solid #fff;border-right: 2px solid #fff;border-left: 2px solid #fff;">
                <td colspan="10">
                    <p class="text-right">Date: <span class="ml-3"><?= date('d/m/Y') ?></span></p>
                    <h2 class="text-center">BG Collection ltd</h2>
                    <div class="text-center " style="margin-bottom:20px;">
                        <span class="text-capitalize"><span class="title">{{ $inventory_info->style_no }}&nbsp;-&nbsp;
                                <span></span> {{ $inventory_info->buyer_name }} Accessories inventory Report</span>
                    </div>
                </td>
            </tr>
            <tr class="table-header" style="border-top: 2px solid #000000;">
                <th>#SL</th>
                <th>A.Name</th>
                <th>Unit</th>
                <th>Color</th>
                <th>Size</th>
                <th>G.Qty</th>
                <th>Req.Qty</th>
                <th>Rec.Qty</th>
                <th>Balance</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
                @php
                    $requered_quantity = $inventory->requered_quantity;
                    $received_quantity = $inventory->received_quantity;
                    $balance = $received_quantity - $requered_quantity;
                    $stock_quantity = $inventory->stock_quantity;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inventory->accessories_name }}</td>
                    <td>{{ $inventory->unit }}</td>
                    <td>{{ $inventory->color_name }}</td>
                    <td>{{ $inventory->size }}</td>
                    <td>{{ $inventory->garments_quantity }}</td>
                    <td>{{ $requered_quantity }}</td>
                    <td>{{ $received_quantity }} </td>
                    <td>{{ $balance }} </td>
                    <td>{{ $stock_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
