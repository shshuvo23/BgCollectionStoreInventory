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
    <table class="table" style="color:#000; margin-top:-30px;">
        <thead>
            <tr>
                <td colspan="10" style="border: 1px solid #fff;">
                    <p class="text-right" style="font-size: 13px; font-weight: 600;">Date: <span class="ml-3"><?= date('d/m/Y') ?></span></p>
                    <h2 class="text-center">BG Collection ltd</h2>
                    <div class="text-center " style="margin-bottom:20px;">
                        <span class="text-capitalize"><span class="title">Export Calender Status</span>
                    </div>
                </td>
            </tr>
            <tr class="table-header">
                <th scope="col">#SL</th>
                <th scope="col">JOB NO</th>
                <th scope="col">BUYER</th>
                <th scope="col">Merchandiser</th>
                <th scope="col">Febrication</th>
                <th scope="col">Order No</th>
                <th scope="col">Order Qty</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total</th>
                <th style="border-right: 1px solid #000" scope="col">Status</th>
            </tr>
        </thead>
        <tbody style="margin:0;padding:0">
            @php
                $monthlyOrderAmount=0;
                $totalOrderAmount=0;
                $monthlyOrderQty=0;
                $totalOrderQty=0;
            @endphp

                @php
                    $serial = 1;
                @endphp
            @foreach ($exportCalenders as $item)
                @php
                    $monthlyOrderAmount+=$item->total;
                    $totalOrderAmount+=$item->total;
                    $monthlyOrderQty+=$item->order_qty;
                    $totalOrderQty+=$item->order_qty;

                @endphp
                @if ($loop->index == 0)
                    <tr>
                        <td colspan="10" align="center" style="font-weight:bold;border-right: 1px solid #000">{{ date('F-Y',strtotime($item->month)) }}</td>
                    </tr>
                @endif

                <tr>
                    <td>{{ $serial++ }}</td>
                    <td>{{ $item->job_no }}</td>
                    <td>{{ $item->buyer_name  }}</td>
                    <td>{{ $item->merchandiser }}</td>
                    <td>{{ $item->fabrication }}</td>
                    <td>{{ $item->order_no }}</td>
                    <td>{{ $item->order_qty }}</td>
                    <td>${{ $item->unit_price }} </td>
                    <td>${{ $item->total }} </td>
                    <td style="border-right: 1px solid #000">{{ $item->status  }}</td>
                </tr>
                @if ($loop->index==count($exportCalenders)-1 || date('m-Y',strtotime($item->month)) != date('m-Y',strtotime($exportCalenders[$loop->index+1]->month)))
                    @php
                        $serial = 1;
                    @endphp
                    <tr><td style="border-right: 1px solid #000"colspan="10" height="10"></td></tr>
                    <tr style="background:rgb(160 201 248)">
                        <td colspan="6" style="font-weight:bold;color:#000; text-align:left">Total</td>
                        <td style="font-weight:bold;color:#000">{{ $monthlyOrderQty  }}</td>
                        <td></td>
                        <td><span style="font-weight:bold;color:#000">${{ $monthlyOrderAmount}}</span></td>
                        <td style="border-right: 1px solid #000" colspan="2"></td>
                    </tr>
                    <tr>
                        @if ($loop->index == count($exportCalenders)-1 )
                        <td  style="border-right: 1px solid #000" align="center" colspan="10" height="10" ><b></b></td>
                        @else
                        <td style="border-right: 1px solid #000" align="center" colspan="10" ><b>{{ date('F-Y',strtotime($exportCalenders[$loop->index+1]->month)) }}</b></td>
                        @endif
                    </tr>
                    @php
                        $monthlyOrderQty=0;
                        $monthlyOrderAmount=0;
                    @endphp
                @endif
            @endforeach

            <tr style="background:#d07236">
                <td colspan="6" style="font-weight:bold;color:#000; text-align:left">Grand Total</td>
                <td style="font-weight:bold;color:#000">{{ $totalOrderQty  }}</td>
                <td></td>
                <td><span style="font-weight:bold;color:#000">${{ $totalOrderAmount}}</span></td>
                <td style="border-right: 1px solid #000" colspan="2"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
