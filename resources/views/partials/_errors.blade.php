<div class="errors-and-successes" align="center">
    @if(\Illuminate\Support\Facades\Session::has('message'))
        <div class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('message') }}</div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert alert-danger">{{ \Illuminate\Support\Facades\Session::get('error') }}</div>
    @endif
</div>
