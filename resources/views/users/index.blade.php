@extends('layouts.main')

@section('content')
    <div class="row index-users">
        <div class="col-sm-9">
            <h2>{{ trans('app.users-index') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('users.create') }}">
                <button class="btn add-new-user">{{ trans('app.users-create') }}</button>
            </a>
        </div>
    </div>
    <div class="row justify-content-center index-users-table">
        <div class="col-sm-8">
            <div>
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($users))
                        @foreach($users as $user)
                            <tr>
                                <td style="width: 20%">{{ $user->name }}</td>
                                <td style="width: 20%">{{ $user->email }}</td>
                                <td style="width: 20%">{{ $user->phone }}</td>
                                <td style="width: 10%">
                                    @if($user->status == 1)
                                        <span>Active</span>
                                    @endif
                                    @if($user->status == 0)
                                        <span>Nonactive</span>
                                    @endif
                                </td>
                                <td style="width: 10%">{{ $user->role }}</td>
                                <td style="width: 10%"><a href="{{ route('users.edit', $user->id) }}"><i class="fa fa-edit"></i></a></td>
                                <td style="width: 10%">
                                    <a href="{{ route('users.delete', $user->id) }}" onclick="return confirm('Are you sure that you want to delete user {{ $user->name }} as {{ $user->role }}?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
