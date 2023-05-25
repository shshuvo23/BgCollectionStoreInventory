@php
    $dashboard = true;
@endphp
@extends('layouts.app')

@section('css')
<link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
    <div class="br-section-wrapper mt-5">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Inventory</h6>
        {{-- <p class="mg-b-25 mg-lg-b-50">Style No: {{$style->style_no}}</p> --}}
        <div class="mb-5 mt-5">
            <label class="" ><strong>Style Number</strong></label><br>
            <select id="StyleId" onchange="getInventory(this.value)" style="max-width: 30%;" class="form-control select2" onchange="getInventory()" id="style_no" name="style_no" required>
                <option value="" selected disabled hidden>--Select Style--</option>
                @foreach ($styles as $style)
                    <option value="{{$style->id}}" {{$_SESSION["style_id"] == $style->id ? 'selected' : ''}}>{{$style->style_no}} ({{$style->buyer_name}})</option>
                @endforeach
            </select>
        </div>
        {{-- @if ($inventories)
            <a href="{{route('download.inventory', Crypt::encrypt($style_id))}}" class="btn btn-primary mr-3"><i class="fa fa-download "></i> Download </a>
            <a href="{{route('print.inventory', Crypt::encrypt($style_id))}}" class="btn btn-secondary mr-3"><i class="fa fa-print "></i> Print </a>
        @endif --}}
        <div id="stock_in_section">



        </div>
    </div>


    </div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

    jQuery(document).ready(function($) {
        $('#indentory-table').DataTable();
        $(".select2").select2({ tags: false});
        let id = $('#StyleId').val();
        getInventory(id);
    });

    function getInventory(id){
        setSession('style_id', id);

        $.get('{{route('inventory_by_ajax')}}', {id:id}, function(data){
            $('#stock_in_section').html(data);
        });

    }

    function setSession(key, value, url = null){
        // alert(url);
        // let location = "{{ route('boking_histories', ':id') }}";
        // location = location.replace(':id', url);

        $.get('{{route('set_session')}}', {key:key, value:value}, function(data){
            if(key == 'back'){
                window.location.href=url;
            }
        });
    }
</script>


@endsection
