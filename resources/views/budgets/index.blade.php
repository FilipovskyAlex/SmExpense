@extends('layouts.main')

@section('content')
    <div class="row index-budgets">
        <div class="col-sm-3">
            <h2>{{ trans('app.budgets-index') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('budgets.index') }}">
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
                <select id="selectBudget" class="form-control" onchange="changePeriod(this.value)">
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
            @if(isset($categories))

                @php
                    $i = 0;
                @endphp

                <h2>Categories</h2>
                <div>
                    @foreach($categories as $category)
                        {{-- Add style for selected category.
                        If category is selected by user,
                        it has background-color from $colors array--}}
                        @php
                            $active = $department == $category->id ? "true" : "false";
                            $display = $department == $category->id ? "display:none" : "display:block";
                            $style = $department == $category->id ? "background-color: $colors[$i]; color: white" : "border: 2px solid $colors[$i]; background-color: white; color: black";
                        @endphp
                        {{-- When we click on department we go to the page where will display budgets for choosing department and period --}}
                        <a style="display: block" href="/budgets?department={{ $category->id }}&period={{ $period_id }}">
                            <div style="{{ $style }}" class="cat-group-budget" datatype="{{ $active }}">
                                <p>{{ $category->name }}</p>
                                <p style="{{ $display }}"><span>Total expense</span>&nbsp;{{ \App\Providers\CommonProvider::format_number($category->expenseTotal) }} / <span>Total budget</span>&nbsp;{{ \App\Providers\CommonProvider::format_number($category->budgetTotal) }}</p>
                                <p style="{{ $display }}"><span>Left:&nbsp;</span>{{ \App\Providers\CommonProvider::format_number($category->budgetTotal - $category->expenseTotal) }}</p>
                            </div>
                        </a>
                        @php $i++ @endphp
                        @php if($i == count($colors) - 1) { $i = 0; } @endphp
                    @endforeach
                </div>
            @endif
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
            @if(count($budgets) > 0)
                <div class="col-sm-12 total-price">
                    <div class="row">
                        <div class="col-sm-6"><span class="total">Budget information</span></div>
                        <div class="col-sm-6 list">
                            <p>Total budget &nbsp:&nbsp<span>{{ \App\Providers\CommonProvider::format_number($totalBudget->totalBudgets) }}</span></p>
                            <p>Spent from budget &nbsp:&nbsp<span>{{ \App\Providers\CommonProvider::format_number($totalSpendBudget->totalBudgets) }}</span></p>
                            <p>Remaining budget &nbsp:&nbsp<span>{{ \App\Providers\CommonProvider::format_number($totalBudget->totalBudgets - $totalSpendBudget->totalBudgets) }}</span></p>
                        </div>
                    </div>
                </div>
            @else
                <h4 align="center">No Item Found</h4>
            @endif
        </div>
    </div>

@endsection

@section('script')
    <script>
        {{-- If we choose period we get that url below with select department and period --}}
        function changePeriod(id) {
            let url = "/budgets?department={{ $department }}&period="+id;

            // currently open window will be on "url" location
            window.location = url;
        }
    </script>
@endsection