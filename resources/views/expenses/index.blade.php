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
@endsection