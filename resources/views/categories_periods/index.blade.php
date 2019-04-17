@extends('layouts.main')

@section('content')
    <div class="row categories-periods-list">
        @include('periods.create')
        @include('categories.create')
    </div>
    <div class="row">
        @include('periods.list')
        @include('categories.list')
    </div>
@endsection

@section('script')
    @extends('partials._script')
@endsection
