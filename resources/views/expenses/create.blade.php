@extends('layouts.main')

@section('content')
    <div class="row create-expenses">
        <div class="col-sm-9">
            <h2>{{ trans('app.expenses-create') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('expenses.index') }}">
                <button class="btn add-new-expense">{{ trans('app.expenses-index') }}&nbsp<i class="fas fa-arrow-left"></i></button>
            </a>
        </div>
    </div>

    <div style="padding-bottom: 40px;" class="row add-new-exp-form justify-content-center">
        <div class="col-sm-7">
            <form class="create-expense-form" action="{{ route('expenses.store') }}" method="post" role="form" id="expenses" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="company_id" value="{{ \Illuminate\Support\Facades\Auth::user()->company_id }}">
                <input type="hidden" name="outside" id="outside" value="{{ old('outside') }}" class="form-control">

                <div class="form-group row">
                    <label for="department" class="col-sm-4 col-form-label text-md-right">{{ __('Budget Item') }}</label>

                    <div class="col-sm-6">
                        <select class="form-control {{ $errors->has('budget_id') ? ' is-invalid' : '' }}" id="budget_id" name="budget_id" onchange="changeBudget(this.value)">
                            <option value="">Choose budget item</option>
                            @if(isset($budgets))
                                @foreach($budgets as $budget)
                                    <option value="{{ $budget->id.':'.$budget->outside.':'.$budget->category_id.':'.$budget->period_id }}">{{ $budget->category.':'.$budget->item }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('budget_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('budget_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="priority" class="col-sm-4 col-form-label text-md-right">{{ __('Priority') }}</label>

                    <div class="col-sm-6">
                        <select class="form-control {{ $errors->has('priority') ? ' is-invalid' : '' }}" id="priority" name="priority">
                            <option value="">Choose priority</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                        @if ($errors->has('priority'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('priority') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('price') ? ' is-invalid' : '' }}">
                    <label for="price" class="col-sm-4 col-form-label text-md-right">{{ __('Price') }}</label>

                    <div class="col-sm-6">

                        <input type="text" value="{{ old('price') }}" class="form-control" name="price" id="price">
                        <p class="red" id="out_of_budget" style="display: none;">Sorry, your price is out of budget limit!</p>

                        @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('subject') ? ' is-invalid' : '' }}">
                    <label for="subject" class="col-sm-4 col-form-label text-md-right">{{ __('Subject') }}</label>

                    <div class="col-sm-6">

                        <input type="text" value="{{ old('subject') }}" class="form-control" name="subject" id="subject">

                        @if ($errors->has('subject'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('description') ? ' is-invalid' : '' }}">
                    <label for="description" class="col-sm-4 col-form-label text-md-right">{{ __('Description') }}</label>

                    <div class="col-sm-6">

                        <textarea class="form-control" name="description" id="description" rows="8">{{ old('description') }}</textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('file') ? ' is-invalid' : '' }}">
                    <label for="file" class="col-sm-4 col-form-label text-md-right">{{ __('Add file') }}</label>

                    <div class="col-sm-6">

                        <input type="file" value="{{ old('file') }}" class="form-control" name="file" id="file">

                        @if ($errors->has('file'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-sm-6 offset-sm-4">
                        <button type="submit" class="btn add-exp-btn">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection