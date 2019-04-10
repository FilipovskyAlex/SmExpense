<!DOCTYPE html>
<html lang="en">
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
