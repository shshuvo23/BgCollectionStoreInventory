@php
    $role_menu =true;
@endphp
@extends('layouts.app')
@section('content')

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="bd rounded table-responsive">
                <table class="table table-hover mg-b-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{  $role->role_name }} </td>
                                <td>
                                    {{-- <div class="dropdown show">
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Action
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a href="{{ route('edit_user', $user->id) }}" class="dropdown-item"><i class="fa fa-pencil mg-r-10 pl-2"></i>Edit</a>
                                            <a   href="javascript:void(0)" onclick="deleteItem({{ $user->id }})" class="dropdown-item"><i class="fa fa-trash pl-2"></i><span class="pl-2">Delete</span></a>

                                            <form id="deleteItem{{ $user->id }}" action="{{ route('delete_user', $user->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </div> --}}
                                </td>
                                {{-- <td>
                                    <a href="{{ route('edit_user', $user->id) }}" class="btn btn-primary btn-icon">
                                        <div><i class="fa fa-pencil"></i></div>
                                    </a>
                                    <form id="deleteItem{{ $user->id }}" action="{{ route('delete_user', $user->id) }}"
                                        method="post">
                                        @csrf
                                        <a href="javascript:void(0)" onclick="deleteItem({{ $user->id }})"
                                            class="btn btn-danger btn-icon">
                                            <div><i class="fa fa-trash"></i></div>
                                        </a>
                                    </form>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- br-pagebody -->
@endsection
