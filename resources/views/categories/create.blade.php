<div class="col-sm-6 create-category">
    <h4 style="padding-left: 45px;">Add Category</h4>
    <form class="create-cat-form" action="{{ route('category.store') }}" method="post" role="form">
        @csrf
        <input type="hidden" name="company_id" value="{{ \Illuminate\Support\Facades\Auth::user()->company_id }}">

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('Name') }}</label>

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

            <div>
                <button type="submit" class="btn add-cat-btn">
                    {{ __('Create') }}
                </button>
            </div>
        </div>
    </form>
</div>
