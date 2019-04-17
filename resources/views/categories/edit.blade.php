@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-6 edit-category">
            <h4>{{ trans('app.categories-edit') }}</h4>
            <form class="edit-cat-form" action="{{ route('category.update', $category->id) }}" method="post" role="form">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-sm-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $category->name }}" autofocus>

                        @if ($errors->has('name'))
                            @foreach ($errors->get('name') as $message)
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @endforeach
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="btn edit-cat-btn">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
