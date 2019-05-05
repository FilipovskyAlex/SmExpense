@extends('layouts.main')

@section('content')
<div class="row justify-content-center dashboard" style="padding-bottom: 50px;">
    <div class="d-flex col-sm-10 main" style="padding-top: 20px;">
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: #f0df4e">
                <h2>Pending</h2>
                <p>{{ $pending }}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: darkred">
                <h2 style="color: whitesmoke">Denied</h2>
                <p style="color: whitesmoke">{{ $denied }}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: darkgreen">
                <h2 style="color: whitesmoke">Approved</h2>
                <p style="color: whitesmoke">{{ $approved }}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: dimgrey">
                <h2>Closed</h2>
                <p>{{ $closed }}</p>
            </div>
        </div>
    </div>
    <div class="d-flex col-sm-10 main" style="padding-top: 20px;">
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: #f68fad">
                <h2 style="color: whitesmoke">Departments</h2>
                <p style="color: whitesmoke">{{ count($categories) }}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: #f68fad">
                <h2 style="color: whitesmoke">Periods</h2>
                <p style="color: whitesmoke">{{ count($periods) }}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: #f68fad">
                <h2 style="color: whitesmoke">Budgets</h2>
                <p style="color: whitesmoke">{{ count($budgets) }}</p>
                <p id="total" style="color: whitesmoke">Total&nbsp;<span>{{ \App\Providers\CommonProvider::format_number($totalBudget->totalBudgets) }}</span></p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="jumbotron" style="background-color: #f68fad">
                <h2 style="color: whitesmoke">Expenses</h2>
                <p style="color: whitesmoke">{{ count($expenses) }}</p>
                <p id="total" style="color: whitesmoke">Total&nbsp;<span>{{ \App\Providers\CommonProvider::format_number($totalSpendBudget->totalBudgets) }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @extends('partials._script')
@endsection
