@extends('layouts.main')

@section('content')
    <div class="row add-new-company">
        <div class="col-sm-10">
            <h1>{{ $companyTitle }}</h1>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('company.index') }}">
                <button class="btn add-new-comp">Companies<i style="padding-left: 10px;" class="fas fa-arrow-left"></i></button>
            </a>
        </div>
    </div>
    <div class="row add-new-comp-form justify-content-center">
        <div class="col-sm-8">
            <form action="{{ route('company.store') }}" method="post" role="form">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-sm-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autofocus>

                        @if ($errors->has('name'))
                            @foreach ($errors->get('name') as $message)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-sm-6 offset-sm-4">
                        <button type="submit" class="btn add-comp-btn">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
