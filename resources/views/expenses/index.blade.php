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
                        <li><a href="/expenses?department={{ $department }}&status=all&period={{ $period_id }}&page={{ $page }}">ALL</a></li>
                        <li><a href="/expenses?department={{ $department }}&status=3&period={{ $period_id }}&page={{ $page }}">Pending</a></li>
                        <li><a href="/expenses?department={{ $department }}&status=2&period={{ $period_id }}&page={{ $page }}">Denied</a></li>
                        <li><a href="/expenses?department={{ $department }}&status=1&period={{ $period_id }}&page={{ $page }}">Approved</a></li>
                        <li><a href="/expenses?department={{ $department }}&status=4&period={{ $period_id }}&page={{ $page }}">Closed</a></li>
                    </ul>
                </nav>
            </div>

            <div class="dropdown" aria-label="selectDepartment">
                <select data-placeholder="Departments" id="selectDepartment" class="form-control" onchange="changeDepartment(this.value)">
                    <option value="all">All departments</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
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

                                        <?php
                                            $color = "darkRed";
                                            if ($expense->status == 1) {
                                                $color = "green";
                                                $textColor = "black";
                                            }
                                            if ($expense->status == 2) {
                                                $color = "red";
                                                $textColor = "black";
                                            }
                                            if ($expense->status == 3) {
                                                $color = "#e6d442";
                                                $textColor = "black";
                                            }
                                            if ($expense->status == 4) {
                                                $color = "black";
                                                $textColor = "white";
                                            }
                                        ?>

                                        <tr>
                                            <td id="checkbox" style="border-left: 3px solid {{ $color }}"><input type="checkbox" name="expenses[]" value=""></td>
                                            <td id="req">
                                                <h5>
                                                    <a href="{{ route('expenses.show', $expense->id) }}">
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
                                                <a href="#"><span class="expense-overdue" style="color: {{ $textColor }}; background-color: {{ $color }}">{{ \App\Expense::getStatus($expense->status) }}</span></a>
                                            </td>
                                            <td id="approve">
                                                @if($expense->approver == null && $expense->status==3)
                                                    <p>Not approved yet.</p>
                                                @else
                                                    <p><img src="{{ \App\Providers\CommonProvider::getImage($expense->approver_logo) }}" alt="" width="45px" height="auto" style="padding-bottom: 5px;"></p>
                                                    <p>{{ $expense->email }}</p>
                                                @endif
                                            </td>
                                            <td id="details" style="border-right: 3px solid {{ $color }}">
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

@section('script')
    <script>
        {{-- If we choose period we get that url below with select department and period and status --}}
        function changePeriod(id) {
            let url = "/expenses?department={{ $department }}&status={{ $status }}&period="+id;

            // currently open window will be on "url" location
            window.location = url;
        }
    </script>

    <script>
        {{-- If we choose departemnt we get that url below with select department and period and status --}}
        function changeDepartment(id) {
            let url = "/expenses?department="+id+"&status={{ $status }}&period={{ $period_id }}";

            window.location = url;
        }
    </script>
@endsection