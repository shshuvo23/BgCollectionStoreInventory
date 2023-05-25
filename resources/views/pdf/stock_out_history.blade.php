<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/BG-Collection-logo-.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <title>Stock Out History Report</title>
    <style>

        @page{
            margin:30px 25px 100px;
        }
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
        footer {
            position: fixed;
            bottom:-60px;
            left: 0px;
        }



    </style>
</head>

<body>
    <table class="table mt-25">
        <thead>


            @php

                   if (strlen($stock_out_id) == 1) {
                        $stock_out_id = '000'.$stock_out_id;
                   }else if (strlen($stock_out_id) == 2) {
                    $stock_out_id = '00'.$stock_out_id;
                   }
                   else if (strlen($stock_out_id) == 3) {
                    $stock_out_id = '0'.$stock_out_id;
                   }else {
                     $stock_out_id = $stock_out_id;
                   }

            @endphp

    <tr>
        <td style="border: 1px solid #fff;" colspan="2" align="left">
            <strong>#SL:  {{ $stock_out_id }}</strong><br>
            <strong>Name:  {{ $style_and_receiver_name->receiver_name }}</strong><br>
            <strong>Line No:  {{ $style_and_receiver_name->line_no }}</strong>
        </td>
        <td style="border: 1px solid #fff;" colspan="3" align="center"><h2 class="text-center">BG Collection ltd</h2></td>
        <td  style="border: 1px solid #fff;"colspan="2" align="right">Date: <span class="ml-3"><?= date('d/m/Y') ?></span></td>
    </tr>

            <tr style="border-top: 2px solid #fff;border-right: 2px solid #fff;border-left: 2px solid #fff;">

                <td colspan="7">
                        <span class="title">Stockout Report of
                            {{ $style_and_receiver_name->buyer_name }}&nbsp;-&nbsp;
                            {{ $style_and_receiver_name->style_no }}
                        </span><br><br>
                    </div>
                </td>
            </tr>
            <tr class="table-header" style="border-top: 2px solid #000000;">
                <th style="width:20%">SL</th>
                <th style="width:20%">Accessories Name</th>
                <th style="width:20%">Unit</th>
                <th style="width:20%">Color</th>
                <th style="width:20%">Size</th>
                <th style="width:20%">Quantity</th>
                <th style="width:20%">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockOutHistories as $item)
                <tr>
                    <th style="width:20%" scope="row">{{ $loop->iteration }}</th>
                    <td style="width:20%">{{ $item->accessories_name }}</td>
                    <td style="width:20%">{{ $item->unit }}</td>
                    <td style="width:20%">{{ $item->color_name?$item->color_name:"N/A" }} </td>
                    <td style="width:20%">{{ $item->size?$item->size:"N/A" }} </td>
                    <td style="width:20%">{{ $item->quantity }} </td>
                    <td style="width:20%">{{ $item->stock_out_date }} </td>
                </tr>




            @endforeach
        </tbody>
    </table>


        {{-- <div class="d-flex justify-content-center">
            <div  style="text-align:center">
                <hr>
                <p style="margin-top: -10px">Received By</p>
             </div>
             <div  style="text-align:center">
                <hr>
                <p style="margin-top: -10px">Issued By</p>
             </div>
        </div> --}}
        <footer>
            <table style="width:1000px">
                <tr width="">
                    <td align="left" width="50%">
                        <div class="p-2" style="margin-left:100px; border-top: 2px solid #0000 ">
                         <div style="height:1px;width:100px;background:#000"></div>
                         <span style="margin-left: 16px">Issued By</span>
                        </div>
                    </td>
                    <td align="right" width="50%" >
                        <div class="p-2">
                            <div style="height:1px;width:100px;background:#000;margin-left:400px"></div>
                            <span >Received By</span>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- <div class="row">
                <div class="col-md-6">

                    <div class="p-2 flex-fill" style="text-align:right; margin-top:-50px; margin-right:20px;"><strong  style="border-top: 2px solid #000; width:200px;">Received By</strong></div>
                </div>
                <div class="col-md-6">

                </div>
            </div> --}}
        </footer>




    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>
