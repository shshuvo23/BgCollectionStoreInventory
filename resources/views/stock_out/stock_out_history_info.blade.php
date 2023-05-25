@php
    $stock_out_history = true;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bg Collection-{{ isset($page_title) ? $page_title : 'Store Management Application' }}</title>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/BG-Collection-logo-.png') }}">
    <link href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bracket.css') }}">
    <style>
          #app{position: relative;}
        .f-bottom{position: absolute; bottom: 0;}
    </style>
</head>
<body>
        @include('layouts.sidebar')
        @include('layouts.nav')
        <div class="br-mainpanel" style="position: relative;">
            <div class="pd-30">
                <h4 class="tx-gray-800 mg-b-5">{{ isset($page_title) ? $page_title : '' }}</h4>
                <p class="mg-b-0">{{ isset($page_message) ? $page_message : '' }}</p>
            </div>
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div  class="d-flex justify-content-between mb-4">
                 <div>
                    <h6 class="text-bolder">Stockout History Details of Style No: &nbsp; <span class="text-info">{{ $history_info->style_no }}</span> &nbsp; and  Receiver Name: &nbsp; <span class="text-primary">{{ $history_info->receiver_name }}</span> </h6>
                 </div>
                 <div>
                    <a href="javascript:void(0)"  onclick="history.back()" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back </a>
                    <a href="{{ route('downLoadStockOutInfo',Crypt::encrypt($stock_out_histories_id)) }}" class="btn btn-info text-white"><i class="fa fa-download"></i><span class="pl-2">Download</span></a>
                    <a href="{{ route('print-stockout-info',Crypt::encrypt($stock_out_histories_id)) }}" class="btn btn-primary text-white"><i class="fa fa-print"></i><span class="pl-2">Print</span></a>
                 </div>
            </div>
            <div class="bd rounded table-responsive">
                <table class="table table-hover mg-b-0" id="datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Accessories Name</th>
                            <th>Unit</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            @if (auth()->user()->role_id == 4)
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockOutHistories as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->accessories_name }}</td>
                                <td>{{ $item->unit }}</td>
                                <td> {{ $item->color_name }}</td>
                                <td> {{ $item->size }} </td>
                                <td> <span class="badge bg-success">{{ $item->quantity }}</span> </td>
                                <td> {{ $item->stock_out_date }} </td>
                                @if (auth()->user()->role_id == 4 or auth()->user()->role_id == 3)
                                <td><a href="{{ route('edit_stock_out_accessories',Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o mr-2"></i>Edit </a> </td>
                                @endif


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- br-pagebody -->
    <footer class="br-footer ">
        <div class="f-bottom" style="text-align:center; padding:10px 0; ">
            <div class="mg-b-2">Copyright &copy; {{ date('Y') }}. BG Collection. All Rights Reserved.</div>
        </div>
    </footer>
            </div>
        </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/lib/popper.js/popper.js') }}"></sc>
<script src="{{ asset('assets/lib/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
<script src="{{ asset('assets/js/bracket.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$("#datatable").DataTable();

</script>
