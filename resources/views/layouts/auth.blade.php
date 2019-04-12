<!DOCTYPE html>
<html lang="en">
@include('partials._head')
<body style="background-color: #FFE6E3">
<div class="container-fluid">
    @yield('authContent')
</div>
@include('partials._script')
@yield('script')
</body>
</html>
