@extends('layouts.main')

@section('content')
    <div class="row showSingleExp">
        <div class="col-sm-10">
            <h1>Expense</h1>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('expenses.index') }}">
                <button class="btn show-exp">Expenses<i style="padding-left: 10px;" class="fas fa-arrow-left"></i></button>
            </a>
        </div>
    </div>
    <div class="row justify-content-center" style="padding-bottom: 70px;">
        <div class="col-sm-10">
            <table class="show-expense-table">
                <tr>
                    <th>ID</th>
                    <td>{{ $expense->id }}</td>
                </tr>
                <tr>
                    <th>Budget</th>
                    <td>{{ \App\Providers\CommonProvider::format_number($expense->budget) }}</td>
                </tr>
                <tr>
                    <th>Left price</th>
                    <td>{{ \App\Providers\CommonProvider::format_number($expense->budget - $expense->price) }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $expense->description }}</td>
                </tr>
                <tr>
                    <th>Priority</th>
                    <td>{{ $expense->priority }}</td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td>{{ $expense->subject }}</td>
                </tr>
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
                    <th>Status</th>

                    <td id="status">
                        <span style="color: {{ $textColor }}; background-color: {{ $color }};">{{ \App\Expense::getStatus($expense->status) }}</span>
                        <div>
                            <select id="expense_status_{{ $expense->id }}" name="expense_id" style="float: left; margin-top: 5px; margin-right: 10px;">
                                <option <? if($expense->status == 1) { echo "selected"; } ?> value="approved">Approved</option>
                                <option <? if($expense->status == 2) { echo "selected"; } ?> value="denied">Denied</option>
                                <option <? if($expense->status == 3) { echo "selected"; } ?> value="pending">Pending</option>
                                <option <? if($expense->status == 4) { echo "selected"; } ?> value="closed">Closed</option>
                            </select>
                            <button type="button" onclick="changeStatus({{ $expense->id }})" class="btn status-btn-change">Update</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Created at</th>
                    <td>{{ date('F d, Y', strtotime($expense->created_at)) }}</td>
                </tr>
                <tr>
                    <th>Last activity</th>
                    <td>{{ date('F d, Y , H:m:s A', strtotime($expense->updated_at)) }}</td>
                </tr>
                <tr>
                    <th>From user</th>
                    <td>{{ $expense->user }}</td>
                </tr>
                <tr>
                    <th>User email</th>
                    <td>{{ $expense->email }}</td>
                </tr>
                <tr>
                    <th>User logo</th>
                    <td><p style="margin-bottom: 0;"><img src="{{ \App\Providers\CommonProvider::getImage($expense->logo) }}" alt="" width="65px" height="auto" style="padding: 5px 0"></p></td>
                </tr>
                <tr>
                    <th>Expense item</th>
                    <td>{{ $expense->item }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $expense->category }}</td>
                </tr>
                @if($expense->approver == null && $expense->status==3)
                    <tr>
                        <th>Approver</th>
                        <td>Not approved yet</td>
                    </tr>
                @else
                    <tr>
                        <th>Approver</th>
                        <td>{{ $expense->approver_name }}</td>
                    </tr>
                    <tr>
                        <th>Approver logo</th>
                        <td><p style="margin-bottom: 0;"><img src="{{ \App\Providers\CommonProvider::getImage($expense->approver_logo) }}" alt="" width="65px" height="auto" style="padding: 5px 0"></p></td>
                    </tr>
                    <tr>
                        <th>Approver email logo</th>
                        <td>{{ $expense->email }}</td>
                    </tr>
                @endif
                <tr>
                    <th>File</th>
                    <td><p style="margin-bottom: 0;"><img src="{{ \App\Providers\CommonProvider::getImage($expense->file) }}" alt="" width="65px" height="auto" style="padding: 5px 0"></p></td>
                </tr>
                <tr id="comments_single_tr_id" style="display: none;">
                    <th>Comments: <span style="color: darkred">Required</span></th>
                    <td>
                        <textarea id="comment_single_{{ $expense->id }}" style="width: 100%;">{{ $expense->comment }}</textarea>
                    </td>
                </tr>

                @if($expense->comment != null)
                    <tr>
                        <th>Comment</th>
                        <td>{{ $expense->comment }}</td>
                    </tr>
                @else
                    <tr>
                        <th>Comment</th>
                        <td>There is no comments yet</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function changeStatus(expenseId) {
            // Comment Box text is always an empty string >> ????
            let commentBox = $("comment_single_"+expenseId).text();
            let status = $("#expense_status_"+expenseId).val();

            if(status === "denied") {
                if(commentBox == '' || commentBox == null) {
                    $("#comments_single_tr_id").slideDown('slow');
                }
                if(commentBox != '' && commentBox != null) {
                    $.post("/expenses/updateStatus", {status: status, comment: commentBox, id: expenseId, _token: '{!! csrf_token() !!}'}).done(function (data) {
                        location.reload();
                    })
                }
            } else {
                $.post("/expenses/updateStatus", {status: status, comment: commentBox, id: expenseId, _token: '{!! csrf_token() !!}'}).done(function (data) {
                    location.reload();
                });
            }
        }
    </script>
@endsection