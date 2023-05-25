@php
    $users_menu =true;
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
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Add new User</h6>
                </div>
            </div>
            @php

            @endphp
            <form action="{{ route('store_user') }}" method="post">
                  @csrf
                <div class="row">
                    <div class="col-lg">
                        <label class=""><strong>User Name</strong></label>
                        <input class="form-control" placeholder="User Name" type="text" name="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><!-- col -->
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class=""><strong>Email</strong></label>
                        <input class="form-control" placeholder="Email" type="email" name="email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                       @enderror
                    </div><!-- col -->


                </div><!-- row -->

                <div class="row mg-t-20">
                    <div class="col-lg">
                        <label class=""><strong>Role</strong></label>
                        <select class="form-control" name="role_id">
                            <option value="" selected disabled hidden>--Select Role--</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                            @error('role_id')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror
                        </select>
                        {{-- <input class="form-control" placeholder=""  type="text"> --}}
                    </div><!-- col -->
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class=""><strong>Password</strong></label>
                        <input class="form-control" placeholder="password" type="password" name="password">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div><!-- col -->

                </div><!-- row -->
                <button class="btn btn-primary mt-3" type="submit">Create User</button>
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




