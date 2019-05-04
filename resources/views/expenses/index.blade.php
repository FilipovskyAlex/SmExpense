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
                    <option value="all">Choose expense period</option>
                    @if(isset($periods))
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" <? if($period_id == $period->id) { echo "selected"; } ?>>{{ date('F d, Y', strtotime($period->from)). ' To '.date('F d, Y', strtotime($period->to)) }}</option>
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
                        <li <? if($status == "all") { echo "style=background-color:#F68991"; } ?>><a href="/expenses?department={{ $department }}&status=all&period={{ $period_id }}&page={{ $page }}">ALL</a></li>
                        <li <? if($status == 3) { echo "style=background-color:#F68991"; } ?>><a href="/expenses?department={{ $department }}&status=3&period={{ $period_id }}&page={{ $page }}">Pending</a></li>
                        <li <? if($status == 2) { echo "style=background-color:#F68991"; } ?>><a href="/expenses?department={{ $department }}&status=2&period={{ $period_id }}&page={{ $page }}">Denied</a></li>
                        <li <? if($status == 1) { echo "style=background-color:#F68991"; } ?>><a href="/expenses?department={{ $department }}&status=1&period={{ $period_id }}&page={{ $page }}">Approved</a></li>
                        <li <? if($status == 4) { echo "style=background-color:#F68991"; } ?>><a href="/expenses?department={{ $department }}&status=4&period={{ $period_id }}&page={{ $page }}">Closed</a></li>
                    </ul>
                </nav>
            </div>

            <div class="dropdown" aria-label="selectDepartment">
                <select data-placeholder="Departments" id="selectDepartment" class="form-control" onchange="changeDepartment(this.value)">
                    <option value="all">All departments</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" <? if($department == $category->id) { echo "selected"; } ?>>{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-sm-9">
            @if(count($expenses) > 0)
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
                        <form action="/expenses/editStatus" role="form" method="post">
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
                                            <td id="checkbox" style="border-left: 3px solid {{ $color }}">
                                                <input class="expenses_checkbox" type="checkbox" name="expenses[]" value="{{ $expense->id }}">
                                            </td>
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
                                                @if($expense->comment != null)
                                                    <p><strong>Comment: </strong>{{ $expense->comment }}</p>
                                                @endif

                                                <div style="clear: both; height: 5px">
                                                    <div style="display: none;" id="comments_box_{{ $expense->id }}">
                                                        <div style="float: left; margin-top: 8px;"><strong>Comments: </strong></div>
                                                        {{-- There is shouldn't be any space btw textarea open and closed tags! Otherwise we cannot get accurate length of the new array of values --}}
                                                        <textarea class="validateCommentBox" name="comments[{{ $expense->id }}]" id="comments_{{ $expense->id }}" style="width: 300px; height: 32px; margin-left: 10px; z-index: 9999"></textarea>
                                                    </div>
                                                </div>

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

                        </tbody>
                    </table>
                    <div class="row">
                        {{-- Pagination --}}
                        <div class="col-sm-4">{!! $expenses->links() !!}</div>

                        @if(\Illuminate\Support\Facades\Auth::user()->id != 3)
                            <div class="col-sm-8">

                                <div style="display: none; margin-bottom: 10px; color: darkred;" id="com_warnings">Please fill comment box these are required</div>
                                <div style="display: none; font-size: 20px; margin-bottom: 10px; margin-top: 10px; color: red;" id="acom_warnings">Please, select the request first</div>

                                <button id="deniedSubmitBtn" name="status" type="submit" value="denied" class="btn btn-danger" style="visibility: hidden;">Deny</button>
                                <button id="closedSubmitBtn" name="status" type="submit" value="closed" class="btn btn-dark" style="visibility: hidden;">Closed</button>
                                <button id="approvedSubmitBtn" name="status" type="submit" value="approved" class="btn btn-success" style="visibility: hidden;">Approved</button>


                                <button type="button" class="btn btn-dark" onclick="closeExpenses()">Close</button>
                                <button type="button" class="btn btn-danger" onclick="denyExpenses()">Deny</button>
                                <button type="button" class="btn btn-success" onclick="approveExpenses()">Approve</button>
                            </div>
                        @endif
                    </div>

                            {{-- CLosing form there because of buttons above --}}
                            </form>
                </div>
            @else
                <h4 align="center">No Item Found</h4>
            @endif
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

    <script>
        function closeExpenses() {
            let commentCounter = 0;

            // Get count of checking fields
            $(".expenses_checkbox").each(function () {
               let checking = $(this).is(':checked');

               if(checking === true) {
                   commentCounter++;
               }
            });

            if(commentCounter > 0) {
                // return true or false
                let confirmation = confirm('Are you sure?');

                if(confirmation === true) {
                    // The invisible button will trigger the form
                    $("#closedSubmitBtn").trigger('click');
                }
            } else {
                $("#acom_warnings").show().fadeOut(2500);
            }
        }
    </script>

    <script>
        function denyExpenses() {
            // Get count of checking fields
            $(".expenses_checkbox").each(function () {
                let checking = $(this).is(':checked');
                let checkboxId = $(this).val();

                if(checking === true) {
                    window.scrollTo(0, 200);
                    $("#comments_box_"+checkboxId).slideDown('slow');
                } else {
                    $("#comments_box_"+checkboxId).slideUp('slow');
                    $("#com_warnings").hide();
                }
            });

            let commentCounter = 0;

            // Get count of checking fields
            $(".expenses_checkbox").each(function () {
                let checking = $(this).is(':checked');

                if(checking === true) {
                    commentCounter++;
                }
            });

            // return a new array of values of filled "textareas"
            let allTextareaFilled = $(".validateCommentBox").filter(function () {
               return this.value;
            });

            // Text areas are not filled
            if(allTextareaFilled.length === 0) {
                $("#com_warnings").show().fadeOut(2500);
            } else if(allTextareaFilled.length === commentCounter) { // Text areas are filled
                let confirmation = confirm('Are you sure?');
                $("#com_warnings").hide();

                if(confirmation === true) {
                    // The invisible button will trigger the form
                    $("#deniedSubmitBtn").trigger('click');
                }
            }
        }
    </script>

    <script>
        function approveExpenses() {
            let commentCounter = 0;

            // Get count of checking fields
            $(".expenses_checkbox").each(function () {
                let checking = $(this).is(':checked');

                if(checking === true) {
                    commentCounter++;
                }
            });

            if(commentCounter > 0) {
                // return true or false
                let confirmation = confirm('Are you sure?');

                if(confirmation === true) {
                    // The invisible button will trigger the form
                    $("#approvedSubmitBtn").trigger('click');
                }
            } else {
                $("#acom_warnings").show().fadeOut(2500);
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $(".checkALL").on('click', function () {
                $(".expenses_checkbox").attr("checked", true);
            });
        });
    </script>
@endsection