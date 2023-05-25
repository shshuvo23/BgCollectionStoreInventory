@php
$stockOutCreate = true;
@endphp
@extends('layouts.app')
 @section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <stock-out></stock-out>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {

            $(".select2").select2({
                tags: true
            });
            $("#style_no").select2();

            $("#receiver").select2({
                tags: true
            });

        });
        $("#datatable").DataTable();
    </script>

    <script>

        function  production(){
            let id = $('#'+'style_no').val();
            $('#'+'styleSeeder').val(id);
            document.getElementById('styleSeeder').dispatchEvent(new Event('change'));
        }

    </script>


@endsection
