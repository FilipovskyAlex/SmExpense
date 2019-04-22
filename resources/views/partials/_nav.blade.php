<nav class="navbar navbar-expand-lg navbar-light navbar-style">
    <a class="navbar-brand" href="{{ route('home') }}">
        @if(\Illuminate\Support\Facades\Auth::user()->company_id !== null)
            {{ \Illuminate\Support\Facades\Auth::user()->company_name }}
            @else
            {{ trans('app.title') }}
        @endif
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav m-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('company.index') }}">Change company <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories_periods.index') }}">Depart. & periods</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Budgets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Expense requests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Users <i class="fas fa-users" style="padding-left: 3px;"></i></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="button-search-style btn my-2 my-sm-0" type="submit">Search</button>
        </form>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Super admin</a>
            </div>
        </div>
    </div>
</nav>
