@extends('layouts.main')

@section('content')
    <div class="row index-budgets">
        <div class="col-sm-9">
            <h2>{{ trans('app.budgets-index') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('budgets.create') }}">
                <button class="btn add-new-budget">{{ trans('app.budgets-create') }}</button>
            </a>
        </div>
    </div>


@endsection