@extends('layouts.main')

@section('content')
    <div class="row index-company">
        <div class="col-sm-9">
            <h2>Companies</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('company.create') }}">
                <button class="btn add-new-comp">{{ trans('app.companies-create') }}<i style="padding-left: 10px;" class="fas fa-arrow-left"></i></button>
            </a>
        </div>
    </div>
@endsection
