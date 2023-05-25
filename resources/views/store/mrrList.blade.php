@php
    $mr_list = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-5">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Store MRR List</h6>
            {{-- <p class="mg-b-25 mg-lg-b-50">Store Stock In Entry form</p> --}}

           <div class="d-none justify-content-end mb-3">
                <div>
                    <label for="" style>Search</label>
                    <input class="form-control" type="search" style="height:2rem;">
                </div>
           </div>

            <div id="mrr_list" style=" width: 100%;">

            </div>
        </div>
    </div>
@endsection

@section('js')

    @if (auth()->user()->role_id == 3)
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $.get('{{ route('mrr_list') }}', function(data) {

                document.getElementById('mrr_list').innerHTML = data;
                $('#mm_table').DataTable();
            });
        });
    </script>

    @endif
@endsection
