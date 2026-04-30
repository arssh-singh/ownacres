
<!-- Sidebar -->
<div class="col-2 bg-light sidebar d-lg-block d-none" id="sidebar">
    <div class="mb-2 p-4 pb-2">
        <div class="container-fluid text-center p-2">
            
            <!-- Profile Image -->
            <img 
                class="img-fluid rounded-circle mb-2" 
                style="width: 60px; height: 60px; object-fit: cover;" 
                src="https://img.freepik.com/free-vector/bird-colorful-gradient-design-vector_343694-2506.jpg?semt=ais_hybrid&w=740&q=80" 
                alt="Profile Image"
            />

            <!-- User Info -->
            <p class="mb-0 fw-semibold small">{{ auth()->user()->name }}</p>
            <p class="text-muted small text-truncate">{{ auth()->user()->email }}</p>

        </div>
    </div>

    <ul class="nav flex-column p-4 pt-0">
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'bg-dark rounded' : '' }}">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'text-light' : 'text-dark' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-columns me-2 fs-5"></i> Dashboard
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('dashboard.properties') ? 'bg-dark rounded' : '' }}">
            <a class="nav-link {{ request()->routeIs('dashboard.properties') ? 'text-light' : 'text-dark' }}" href="{{ route('dashboard.properties') }}">
                <i class="bi bi-houses me-2 fs-5"></i>  Properties
            </a>
        </li>

        <li class="nav-item mt-5">
            <a class="btn btn-primary w-100 shadow py-2" href="{{ route('create-prop') }}">
                + List New Property
            </a>
        </li>
    </ul>
</div>
