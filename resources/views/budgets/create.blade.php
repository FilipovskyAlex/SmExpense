@extends('layouts.main')

@section('content')
    <div class="row create-budgets">
        <div class="col-sm-9">
            <h2>{{ trans('app.budgets-create') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('budgets.index') }}">
                <button class="btn add-new-budget">{{ trans('app.budgets-index') }}&nbsp<i class="fas fa-arrow-left"></i></button>
            </a>
        </div>
    </div>

    <div style="padding-bottom: 40px;" class="row add-new-bud-form justify-content-center">
        <div class="col-sm-7">
            <form class="create-budget-form" action="{{ route('budgets.store') }}" method="post" role="form">
                @csrf
                <input type="hidden" name="company_id" value="{{ \Illuminate\Support\Facades\Auth::user()->company_id }}">

                <div class="form-group row">
                    <label for="department" class="col-sm-4 col-form-label text-md-right">{{ __('Department') }}</label>

                    <div class="col-sm-6">
                        <select class="form-control {{ $errors->has('department') ? ' is-invalid' : '' }}" id="department" name="department">
                            <option value="">Choose department</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('department'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('department') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="period" class="col-sm-4 col-form-label text-md-right">{{ __('Period') }}</label>

                    <div class="col-sm-6">
                        <select class="form-control {{ $errors->has('period') ? ' is-invalid' : '' }}" id="period" name="period">
                            <option value="">Choose period</option>
                            @if(isset($periods))
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}">{{ date('F d, Y', strtotime($period->from)). ' To '.date('F d, Y', strtotime($period->to)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('period'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('period') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="item" class="col-sm-4 col-form-label text-md-right">{{ __('Item') }}</label>

                    <div class="col-sm-6">
                        <input id="item" type="text" class="form-control{{ $errors->has('item') ? ' is-invalid' : '' }}" name="item" value="{{ old('item') }}" autofocus>

                        @if ($errors->has('item'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('item') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="unit" class="col-sm-4 col-form-label text-md-right">{{ __('Unit price') }}</label>

                    <div class="col-sm-6">
                        <input id="unit" onkeyup="calcBudget()" type="text" class="form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}" name="unit" value="{{ old('unit') }}" autofocus>

                        @if ($errors->has('unit'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('unit') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="quantity" class="col-sm-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                    <div class="col-sm-6">
                        <input id="quantity" onkeyup="calcBudget()" type="text" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity') }}" autofocus>

                        @if ($errors->has('quantity'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="budget" class="col-sm-4 col-form-label text-md-right">{{ __('Budget') }}</label>

                    <div class="col-sm-6">
                        <input id="budget" type="text" class="form-control{{ $errors->has('budget') ? ' is-invalid' : '' }}" name="budget" value="{{ old('budget') }}" readonly="readonly">

                        @if ($errors->has('budget'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('budget') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-sm-6 offset-sm-4">
                        <button type="submit" class="btn add-bud-btn">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function calcBudget() {

            let unitPrice = $("input[name = 'unit']").val();
            let quantity = $("input[name = 'quantity']").val();
            let budget = unitPrice * quantity;

            // We parse our number to float type and set afterDigits to 0
            budget = parseFloat(budget).toFixed(0);
            $("input[name = 'budget']").val(budget);
        }
    </script>
@endsection