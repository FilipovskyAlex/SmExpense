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
                @php
                    $i = 0;
                @endphp
                <ul>
                    @foreach($companies as $company)
                        <li>
                            {{-- Encode the url in case of misrequesting by bad user(he changes the id in the query string) --}}
                            <a href="{{ route('company.active', 'company='.urlencode(base64_encode($company->id))) }}">
                                {{-- Add style for active company.
                                If company is selected by user,
                                it has border with white background-color --}}
                                @php
                                    $style = \Illuminate\Support\Facades\Auth::user()->company_id === $company->id
                                    ? "border: 2px solid $colors[$i]; background-color: white; color: black"
                                    : "background-color: $colors[$i]";
                                @endphp
                                <button style="{{ $style }}" class="btn comp-list-btn">{{ $company->name }}</button>
                            </a>
                        </li>
                        @php $i++ @endphp
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
