@extends('layouts.app')
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="br-section-wrapper mt-4">
            <div class="row mb-5 justify-content-center">
                <div class="col-sm-12 col-md-6 ">
                    <div class="row">
                        <div class="col-12 ">
                            <form method="POST" action="{{ route('password.change') }}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label  for="CurrentPassword">Current Password <span class="text-danger">*</span></label>
                                        <input required type="text" id="CurrentPassword" name="current_password" class="form-control" placeholder="Enter your current password" >
                                        @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label  for="newPassword">New Password <span class="text-danger">*</span></label>
                                        <input required type="text" id="newPassword" name="password" class="form-control" placeholder="Enter new password">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label  for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                        <input required type="text" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter password again">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-warning" type="submit">{!! updateBtn() !!}</button>
                            </form>
                            {{-- <form method="POST" action="{{ route('password.change') }}">
                                <div class="form-group row">
                                    <label for="CurrentPassword" class="col-sm-4 col-form-label">Current Password <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" id="CurrentPassword" name="current_password"
                                            class="form-control" placeholder="Enter your current password">
                                        @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="newPassword" class="col-sm-4 col-form-label">New Password <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" id="newPassword" name="password" class="form-control"
                                            placeholder="Enter new password">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-4 col-form-label">Confirm Password<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" id="password_confirmation" name="password_confirmation"
                                            class="form-control" placeholder="Enter password again">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-12">
                                        <button class="btn btn-warning" type="submit">{!! updateBtn() !!}</button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
