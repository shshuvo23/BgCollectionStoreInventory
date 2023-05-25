@php
    $users_menu =true;
@endphp
@extends('layouts.app')
@section('content')

    <div class="br-pagebody">
        @if ($trashed_users > 0)
        <a href={{ route('trashed_users') }}  class="btn btn-danger float-right my-3 mx-3 text-white"><i class="fa fa-trash"></i><span class="pl-2">Recycle Bin({{ $trashed_users }})</span></a>
        @endif

        <div class="br-section-wrapper">
            <div class="bd rounded table-responsive">
                <table class="table table-hover mg-b-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            @if (auth()->user()->role_id== 1 or auth()->user()->role_id == 6)
                            <th>Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        @php
                            if ($user->role_id ==1) {
                                $bg = 'bg-primary';
                            }elseif ($user->role_id ==2) {
                                $bg = 'bg-secondary';
                            }elseif ($user->role_id ==3) {
                                $bg = 'bg-success';
                            }elseif ($user->role_id ==4) {
                                $bg = 'bg-info';
                            }elseif ($user->role_id ==5) {
                                $bg = 'bg-dark';
                            }else{
                                $bg = 'bg-danger';
                            }
                        @endphp
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td> <span class="badge {{$bg }}"> {{  $user->role_name }}</span> </td>
                                @if (auth()->user()->role_id == 1 or auth()->user()->role_id == 6)
                                <td>
                                    <div class="dropdown show">
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
                                    </div>
                                </td>
                                @endif
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
