@php
    $dashboard = true;
@endphp

@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        @if (auth()->user()->role_id == 3)
            @include('store.index')
        @endif

        @if (auth()->user()->role_id == 4)
            @include('stock_out.index')
        @endif

        @if (auth()->user()->role_id == 1)
            @include('users.dashboard')
        @endif
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".select2").select2({
            tags: true
        });
    </script>

    @if (auth()->user()->role_id == 3)
        <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script>
            jQuery(document).ready(function($) {
                $('#style-table').DataTable();
                $(".clickable-row").click(function() {
                    //window.location = $(this).data("href");
                });
            });
        </script>

        <script>
            function setSession(key, value, url = null) {
                $.get('{{ route('set_session') }}', {
                    key: key,
                    value: value
                }, function(data) {
                    window.location.href = url;
                });
            }
        </script>
    @endif
@endsection
