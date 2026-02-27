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
                    <a class="nav-link active" aria-current="page" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item d-flex align-items-center d-md-none gap-3 fw-medium">
                    <a class="nav-link" href="{{ route('login') }}">Log In</a>
                    |
                    <a class="nav-link" href="{{ route('signup') }}">Sign Up</a>
                </li>
            </ul>
        </div>
        <div class="d-none d-md-flex justify-content-end w-md-25 gap-3 fs-09 fw-medium">
            <a class="nav-link" href="{{ route('login') }}">Log In</a>
            |
            <a class="nav-link" href="{{ route('signup') }}">Sign Up</a>
        </div>
    </div>
</nav>
