@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-7 edit-period">
            <h4>Edit Period</h4>

            @if ($errors->has('from'))
                <span style="display: block; padding-left: 45px;" class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('from') }}</strong>
        </span>
            @endif

            @if ($errors->has('to'))
                <span style="display: block; padding-left: 45px;" class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('to') }}</strong>
        </span>
            @endif

            <form class="edit-period-form" action="{{ route('period.update', $period->id) }}" method="post" role="form">
                @csrf

                <div class="form-group row">
                    <label for="range" class="col-sm-2 col-form-label text-md-right">{{ __('Range') }}</label>

                    <div class="col-sm-6">
                        <div class="datarange">
                            <input id="from" type="date" name="from" size="15px" autofocus value="{{ $period->from }}">
                            <span style="padding: 0 5px;">To</span>
                            <input id="to" type="date" name="to" size="15px" autofocus value="{{ $period->to }}">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn edit-per-btn">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
