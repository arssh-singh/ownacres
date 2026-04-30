<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid py-2 px-lg-5">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">OWNACRES</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item {{ request()->routeIs("home") ? 'active-link' : '' }}" >
                <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item {{ request()->routeIs("marketplace") ? 'active-link' : '' }}">
                <a class="nav-link" aria-current="page" href="{{ route('marketplace')}}">Marketplace</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Blogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About Us</a>
            </li>
        </ul>
        <div class="d-flex">
            @guest
                <a href="{{ route('login') }}" class="btn btn-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-dark">Sign Up</a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-success me-2">Dashboard</a>

                <form method="POST" action="{{ route('logout')}}" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger">Logout</button>
                </form>
            @endauth

        </div>
        
    </div>
</nav>