@extends('layouts.main')

@section('content')
    <div class="row index-users">
        <div class="col-sm-9">
            <h2>{{ trans('app.users-index') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('user.create') }}">
                <button class="btn add-new-user">{{ trans('app.users-create') }}</button>
            </a>
        </div>
    </div>
@endsection