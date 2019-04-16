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
    <div class="row company-list justify-content-center">
        <div class="col-sm-7">
            <h5 align="center" style="color: #f62e75;">A list of companies</h5>

            @if(isset($companies))
                <ul>
                    @foreach($companies as $company)
                        <li>
                            <a href="#">
                                <button class="btn comp-list-btn">{{ $company->name }}</button>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
