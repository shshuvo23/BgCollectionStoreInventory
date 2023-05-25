@php
    $dashboard = true;
@endphp
@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Calende Viewer Dashboard </h6>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
