@extends('layouts.main')

@section('content')
    <div class="row index-budgets">
        <div class="col-sm-3">
            <h2>{{ trans('app.budgets-index') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="#">
                <button style="width: 9rem; letter-spacing: 2px" class="btn add-new-budget">List all &nbsp<i
                            class="fas fa-list"></i></button>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('budgets.create') }}">
                <button class="btn add-new-budget">{{ trans('app.budgets-create') }}</button>
            </a>
        </div>
        <div class="col-sm-3 chooseBud">
            <div class="dropdown" aria-label="selectBudget">
                <select id="selectBudget" class="form-control">
                    <option>Choose budget period</option>
                    @if(isset($periods))
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ date('F d, Y', strtotime($period->from)). ' To '.date('F d, Y', strtotime($period->to)) }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="row table-budgets">
        <div class="col-sm-2 budget-sidebar">
            <h2>Categories</h2>
        </div>
        <div class="col-sm-9">
            <div class="budget-table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th id="budget-item" style="width: 55%">Budget item</th>
                        <th style="width: 15%">Unit</th>
                        <th style="width: 15%">Quantity</th>
                        <th style="width: 15%">Budget</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($budgets))
                        @foreach($budgets as $budget)
                            <tr>
                                <td class="request">
                                    <h5><span>{{ $budget->item }}</span></h5>
                                    <p>Created: &nbsp<span>{{ date('F d, Y', strtotime($budget->created_at)) }}</span></p>
                                    <p>By:&nbsp<span>{{ $budget->name }}</span></p>
                                </td>
                                <td class="amount">{{ \App\Providers\CommonProvider::format_number($budget->unit) }}</td>
                                <td class="approvers">{{ $budget->quantity }}</td>
                                <td class="details">{{ \App\Providers\CommonProvider::format_number($budget->budget) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            @if(isset($budgets))
                <div class="col-sm-12 total-price">
                    <div class="col-sm-5 total">
                        <span>Budget information</span>
                        <div class="col-sm-5 list">
                            <p>Total budget &nbsp:&nbsp<span>{{ \App\Providers\CommonProvider::format_number(100) }}</span></p>
                            <p>Spent from budget &nbsp:&nbsp<span>{{ \App\Providers\CommonProvider::format_number(34343) }}</span></p>
                            <p>Remaining budget &nbsp:&nbsp<span>{{ \App\Providers\CommonProvider::format_number(5555555) }}</span></p>
                        </div>
                    </div>
                </div>
            @else
                <h4 align="center">No Item Found</h4>
            @endif
        </div>
    </div>

@endsection