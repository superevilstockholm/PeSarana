<nav class="navbar navbar-expand-md bg-transparent sticky-top" style="backdrop-filter: blur(10px);">
    <div class="container">
        <div class="w-md-25 d-flex align-items-center justify-content-start">
            <a class="navbar-brand fw-semibold p-0 m-0" href="{{ route('index') }}">
                <img height="40" src="{{ asset('static/img/logo-horizontal.svg') }}" alt="Logo PeSarana">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-md-50 collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav fs-09 gap-3 fw-medium">
                <li class="nav-item">
                    <a class="nav-link" href="#about">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#stats">Statistik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#faq">FAQ</a>
                </li>
                <li class="nav-item d-flex align-items-center d-md-none gap-3 fw-medium">
                    @if (auth()->user())
                        <div class="dropdown w-100">
                            <a class="d-flex align-items-center text-decoration-none dropdown-toggle gap-2 mb-4" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->profile_picture_path_url ?? asset('static/img/default-profile-picture.svg') }}" alt="avatar" width="32" height="32" class="rounded-circle">
                                <span class="d-inline">
                                    {{ auth()->user()->name }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <li>
                                    <a class="dropdown-item fs-09" href="{{ route('dashboard.' . auth()->user()->role->value . '.index') }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item fs-09" href="{{ route('dashboard.profile') }}">
                                        Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger fs-09">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Log In</a>
                        |
                        <a class="nav-link" href="{{ route('signup') }}">Sign Up</a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="d-none d-md-flex justify-content-end w-md-25 gap-3 fs-09 fw-medium">
            @if (auth()->user())
                <div class="dropdown">
                    <a class="d-flex align-items-center text-decoration-none dropdown-toggle gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->profile_picture_path_url ?? asset('static/img/default-profile-picture.svg') }}" alt="avatar" width="32" height="32" class="rounded-circle">
                        <span class="d-inline">
                            {{ auth()->user()->name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li>
                            <a class="dropdown-item fs-09" href="{{ route('dashboard.' . auth()->user()->role->value . '.index') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item fs-09" href="{{ route('dashboard.profile') }}">
                                Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger fs-09">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="nav-link" href="{{ route('login') }}">Log In</a>
                |
                <a class="nav-link" href="{{ route('signup') }}">Sign Up</a>
                @endif
            </div>
        </div>
</nav>
