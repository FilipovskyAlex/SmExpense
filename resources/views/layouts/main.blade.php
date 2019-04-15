<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials._head')
    <body>
    @include('partials._nav')
    <div class="container-fluid">
        @include('partials._errors')
        @yield('content')
        @include('partials._footer')
    </div>
    @yield('script')
    </body>
</html>
