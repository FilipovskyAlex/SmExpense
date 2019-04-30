@extends('layouts.main')

@section('content')
    <div class="row index-expense">
        <div class="col-sm-3">
            <h2>{{ trans('app.expenses-index') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('expenses.index') }}">
                <button style="width: 9rem; letter-spacing: 2px" class="btn add-new-expense">List all &nbsp<i
                            class="fas fa-list"></i></button>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('expenses.create') }}">
                <button class="btn add-new-expense">{{ trans('app.expenses-create') }}</button>
            </a>
        </div>
        <div class="col-sm-3 chooseExp">
            <div class="dropdown" aria-label="selectExpense">
                <select id="selectExpense" class="form-control" onchange="changePeriod(this.value)">
                    <option>Choose expense period</option>
                    @if(isset($periods))
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ date('F d, Y', strtotime($period->from)). ' To '.date('F d, Y', strtotime($period->to)) }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="row table-expenses">
        <div class="col-sm-2 expense-sidebar">
            <h2>Filters</h2>
            <div>
                <nav>
                    <ul class="">
                        <li><a href="/expenses?department=1&status=all$&period=1&page=1">ALL</a></li>
                        <li><a href="/expenses?department=1&status=3$&period=1&page=1">Pending</a></li>
                        <li><a href="/expenses?department=1&status=2$&period=1&page=1">Denied</a></li>
                        <li><a href="/expenses?department=1&status=1$&period=1&page=1">Approved</a></li>
                        <li><a href="/expenses?department=1&status=4$&period=1&page=1">Closed</a></li>
                    </ul>
                </nav>
            </div>

            <div class="dropdown" aria-label="selectDepartment">
                <select id="selectDepartment" class="form-control" onchange="changeF(this.value)">
                    <option value="">Choose department</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
{{--                <div>--}}
{{--                    @foreach($categories as $category)--}}
{{--                        --}}{{-- Add style for selected category.--}}
{{--                        If category is selected by user,--}}
{{--                        it has background-color from $colors array--}}
{{--                        @php--}}
{{--                            $active = $department == $category->id ? "true" : "false";--}}
{{--                            $display = $department == $category->id ? "display:none" : "display:block";--}}
{{--                            $style = $department == $category->id ? "background-color: $colors[$i]; color: white" : "border: 2px solid $colors[$i]; background-color: white; color: black";--}}
{{--                        @endphp--}}
{{--                        --}}{{-- When we click on department we go to the page where will display budgets for choosing department and period --}}
{{--                        <a style="display: block" href="/budgets?department={{ $category->id }}&period={{ $period_id }}">--}}
{{--                            <div style="{{ $style }}" class="cat-group-budget" datatype="{{ $active }}">--}}
{{--                                <p>{{ $category->name }}</p>--}}
{{--                                <p style="{{ $display }}">Expense total / Budget total</p>--}}
{{--                                <p style="{{ $display }}">Spent</p>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                        @php $i++ @endphp--}}
{{--                        @php if($i == count($colors) - 1) { $i = 0; } @endphp--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
        <div class="col-sm-9">
            <div class="expense-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 3%"><input type="checkbox" class="checkALL" name="checkALL"></th>
                            <th id="request" style="width: 50%">Requset</th>
                            <th style="width: 10%">$</th>
                            <th style="width: 13%">Approvers</th>
                            <th style="width: 14%">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="" role="form" method="post">
                            @csrf
                            @if(isset($expenses))
                                @foreach($expenses as $expense)
                                    @if($expense->company_id == \Illuminate\Support\Facades\Auth::user()->company_id)
                                        <tr>
                                            <td id="checkbox"><input type="checkbox" name="expenses[]" value=""></td>
                                            <td id="req">
                                                <h5>
                                                    <a href="#">
                                                        {{ $expense->subject }}
                                                    </a>
                                                    /
                                                    <span>
                                                        {{ $expense->item }} (
                                                        <span style="color: #f62e75">
                                                            {{ \App\Providers\CommonProvider::format_number($expense->budget - $expense->price) }}
                                                        </span>)
                                                    </span>
                                                </h5>
                                                <p><span>User name:&nbsp; {{ $expense->user }}&nbsp;&nbsp;</span>Created at: <span>{{ date('F d, Y', strtotime($expense->created_at)) }}</span></p>
                                                <p><strong>{{ $expense->comment }}</strong></p>
                                            </td>
                                            <td id="amount">
                                                <p>{{ \App\Providers\CommonProvider::format_number($expense->budget)}}</p>
                                                <a href="#"><span class="expense-overdue">{{ \App\Expense::getStatus($expense->status) }}</span></a>
                                            </td>
                                            <td id="approve">
                                                <p><img src="" alt="" width="25px"></p>
                                                <p><img src="" alt="" width="25px"></p>
                                                <p>{{ $expense->email }}</p>
                                            </td>
                                            <td id="details">
                                                <div class="details-expense">
                                                    <h5>{{ $expense->category }}</h5>
                                                    <p><span>&nbsp;{{ \App\Providers\CommonProvider::format_number($expense->price) }}</span>&nbsp;requested</p>
                                                    <p><span style="color: #9561e2">{{ \App\Providers\CommonProvider::format_number($expense->budget - $expense->price) }}</span>&nbsp; left</p>
                                                    <p><strong>Priority</strong> {{ $expense->priority }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </form>
                    </tbody>
                </table>
                <div class="col-sm-8">
                    <button type="button" class="btn btn-dark" onclick="closeExpenses()">Close</button>
                    <button type="button" class="btn btn-danger" onclick="denyExpenses()">Deny</button>
                    <button type="button" class="btn btn-success" onclick="approveExpenses()">Approve</button>
                </div>
            </div>
        </div>

    </div>
@endsection