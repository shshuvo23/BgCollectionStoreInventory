@php
    $buyer_list = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <style>
        .ancor_link{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="d-flex justify-content-between  mb-3">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">All Buyer List </h6>
                </div>
                <div>
                    @include('mr.short_code.backbutton')
                </div>
            </div>
            <div class="table-responsive ">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Buyers Name</th>
                            <th>Total Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buyers as $buyer)

                            <tr class="ancor_link" >
                                <th onclick="anchorTag( '{{ route('order.list', Crypt::encrypt($buyer->id)) }}' )" scope="row">{{ $loop->iteration }}</th>
                                <td onclick="anchorTag( '{{ route('order.list', Crypt::encrypt($buyer->id)) }}' )">{{ $buyer->buyer_name }}</td>
                                <td onclick="anchorTag( '{{ route('order.list', Crypt::encrypt($buyer->id)) }}' )">{{ DB::table('orders')->where('buyer_id', $buyer->id)->count() }}</td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Action
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a href=" {{ route('order.list', Crypt::encrypt($buyer->id)) }}"
                                                class="dropdown-item"><i class="fa fa-eye"></i> View Orders</a>
                                            @if (auth()->user()->role_id != 5 && auth()->user()->role_id != 1)
                                                <a href="{{ route('buyer.edit', Crypt::encrypt($buyer->id)) }}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            function getOrders() {

            }
            $('#dataTable').DataTable();
        });

        function anchorTag(link){
            window.location = link;
        }
    </script>
@endsection
