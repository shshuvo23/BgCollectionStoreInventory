@php
    // $users_menu =true;
@endphp
@extends('layouts.app')
@section('content')

    <div class="br-pagebody">
        <a href={{ route('users') }} class="btn btn-primary float-right my-3 mx-3 text-white"><i class="fa fa-user"></i><span class="pl-2">Users List</span></a>
        <div class="br-section-wrapper">

            <div class="bd rounded table-responsive">
                <table class="table table-bordered mg-b-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trashed_users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                               @if (isset($user->role->role_name))
                               <td>{{ $user->role->role_name }}</td>
                               @endif
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                 Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <form id="restoreUser{{ $user->id }}" action="{{ route('restore_user', $user->id) }}"
                                                method="post">
                                                @csrf
                                            <a class="dropdowm-item" onclick="restoreUser({{ $user->id }})" href="avascript:void(0)" style="color:#000"><i class="fa fa-pencil mg-r-10 pl-2"></i>Restore</a>
                                           </form>
                                            <form id="pdeleteItem{{ $user->id }}" action="{{ route('parmanentlyDelete', $user->id) }}"
                                                method="post">
                                                @csrf
                                                <a class="dropdowm-item" onclick="pdeleteItem({{ $user->id }})" href="javascript:void(0)" style="color:#000"><i class="fa fa-trash pl-2"></i><span class="pl-2">Parmanently Delete</span></a>
                                            </form>
                                        </div>
                                      </div>
                                </td>
                            </tr>
                            @empty
                            <td colspan="7" class="text-center text-danger">Not Found</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- br-pagebody -->

    <script>
        function restoreUser(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You you want to restore this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#restoreUser' + id).submit()
                }
            })
        }
        function pdeleteItem(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You you want to permanently this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#pdeleteItem' + id).submit()
                }
            })
        }
    </script>
@endsection
