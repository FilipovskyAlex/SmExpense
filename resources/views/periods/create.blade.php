<div class="col-sm-6 create-period">
    <h4 style="padding-left: 45px;">Add Period</h4>

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

    <form class="create-period-form" action="{{ route('period.store') }}" method="post" role="form">
        @csrf
        <input type="hidden" name="company_id" value="{{ \Illuminate\Support\Facades\Auth::user()->company_id }}">

        <div class="form-group row">
            <label for="range" class="col-sm-2 col-form-label text-md-right">{{ __('Range') }}</label>

            <div class="col-sm-6">
                <div class="datarange">
                    <input id="from" type="text" name="from" size="15px" autofocus>
                    <span style="padding: 0 5px;">To</span>
                    <input id="to" type="text" name="to" size="15px" autofocus>
                </div>
            </div>

            <div>
                <button type="submit" class="btn add-per-btn">
                    {{ __('Create') }}
                </button>
            </div>
        </div>
    </form>
</div>
