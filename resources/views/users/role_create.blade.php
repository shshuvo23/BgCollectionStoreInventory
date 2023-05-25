@php
    $role_menu =true;
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
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Add new Role</h6>
                </div>
            </div>
            @php

            @endphp
            <form action="{{ route('role_store') }}" method="post">
                  @csrf
                <div class="row">
                    <div class="col-lg">
                        <label class=""><strong>Role Name</strong></label>
                        <input class="form-control" placeholder="User Name" type="text" name="role_name">
                        @error('role_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><!-- col -->
                    <div class="col-lg">
                        <label class=""><strong>Role Id</strong></label>
                        <input class="form-control" placeholder="User Name" type="number" name="role_id">
                        @error('role_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><!-- col -->
                </div><!-- row -->
                <button class="btn btn-primary mt-3" type="submit">Create Role</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(".select2").select2({
            tags: true
        });

    </script>
@endsection




