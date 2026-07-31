<style>
    .bar-transparent{
        backdrop-filter: blur(10px);
        border-bottom: solid .1px #ffffff5d;
    }
    .bar{
        transition: all .7s cubic-bezier(0.22, 1, 0.36, 1);
        transform: scaleX(1);
    }
    .bar-down{
        background-color: #ffffff85 !important;
        margin-left: 45px !important;
        margin-right: 45px !important;
        margin-top: 25px !important;

        border-radius: 50px;

        transform: scaleX(0.96);

        transition:
            margin .7s cubic-bezier(0.22,1,0.36,1),
            transform .7s cubic-bezier(0.22,1,0.36,1),
            border-radius .7s cubic-bezier(0.22,1,0.36,1);
    }
    .navbar-expanded {
    background: #fff !important;
    backdrop-filter: none !important;
}

.navbar-expanded .navbar-brand,
.navbar-expanded .nav-link {
    color: #212529 !important;
}
.navbar-expanded{
    background:#fff !important;
    backdrop-filter:none !important;
}
</style>
@if(request()->routeIs('home'))
<nav class="navbar navbar-expand-lg navbar-dark fixed-top p-1 " id="bar" style="background-color: #ffffff00; " style="view-transition-name: navbar;">
@else
<nav class="navbar navbar-expand-lg navbar-light fixed-top p-1" id="bar" style="background-color: #ffff" style="view-transition-name: navbar;">
@endif
    <div class="container-fluid py-2 px-lg-5">
        <a class="navbar-brand fade-anim" href="{{ route('home') }}">
            <img src="{{ asset('storage/images/logo.png') }}" alt="OwnAcres" height="45">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item {{ request()->routeIs("home") ? 'active-link' : '' }}" >
                <a class="nav-link fade-anim" aria-current="page" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item {{ request()->routeIs("marketplace") ? 'active-link' : '' }}">
                <a class="nav-link fade-anim" aria-current="page" href="{{ route('marketplace')}}">Marketplace</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fade-anim" aria-current="page" href="{{ route('dealers') }}">Dealers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fade-anim" href="{{ route('blogs') }}">Education</a>
            </li>
        </ul>
        <div class="d-flex">
            @guest
                <a href="{{ route('login') }}" class="btn me-2 fade-anim {{ request()->routeIs('home') ? 'text-light' : 'text-dark' }}" id="btn-log">Login</a>
                <a href="{{ route('register.form') }}" class="btn fade-anim {{ request()->routeIs('home') ? 'text-light' : 'text-dark' }}" id="btn-sign">Sign Up</a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="btn me-2 fade-anim {{ request()->routeIs('home') ? 'text-light' : 'text-dark' }}" id="btn-dash">Dashboard</a>

                <form method="POST" action="{{ route('logout')}}" style="display:inline;">
                    @csrf
                    <button class="btn fade-anim {{ request()->routeIs('home') ? 'text-light' : 'text-dark' }}" id="btn-logout">Logout</button>
                </form>
            @endauth

        </div>
        
    </div>
</nav>
@push('scripts')
<script>
const bar = document.getElementById('bar');
const btnlog = document.getElementById('btn-log');
const btnsign = document.getElementById('btn-sign');
const btndash = document.getElementById('btn-dash');
const btnlogout = document.getElementById('btn-logout');

window.addEventListener('scroll', function () {

    if (window.scrollY > 500) {

        bar.classList.remove('navbar-dark');
        bar.classList.add('bar-down', 'navbar-light', 'shadow-lg');

        @if (request()->routeIs('home'))
            if(btnlog) { btnlog.classList.remove('text-light'); btnlog.classList.add('text-dark'); }
            if(btnsign) { btnsign.classList.remove('text-light'); btnsign.classList.add('text-dark'); }
            if(btndash) { btndash.classList.remove('text-light'); btndash.classList.add('text-dark'); }
            if(btnlogout) { btnlogout.classList.remove('text-light'); btnlogout.classList.add('text-dark'); }
        @endif

    }
    if (window.scrollY > 0){
        bar.classList.add('bar-transparent');
    }   
    else {

        bar.classList.remove('bar-transparent', 'bar-down', 'shadow-lg');

        @if(request()->routeIs('home'))
            bar.classList.add('bar', 'navbar-dark');
            bar.classList.remove('navbar-light');

            if(btnlog) { btnlog.classList.remove('text-dark'); btnlog.classList.add('text-light'); }
            if(btnsign) { btnsign.classList.remove('text-dark'); btnsign.classList.add('text-light'); }
            if(btndash) { btndash.classList.remove('text-dark'); btndash.classList.add('text-light'); }
            if(btnlogout) { btnlogout.classList.remove('text-dark'); btnlogout.classList.add('text-light'); }
        @else
            bar.classList.add('bar');
            bar.classList.remove('navbar-dark');
            bar.classList.add('navbar-light');
        @endif
    }
});
const navbarCollapse = document.getElementById('navbarSupportedContent');

navbarCollapse.addEventListener('show.bs.collapse', function () {
    bar.classList.add('navbar-expanded');
    bar.classList.remove('bar-transparent');

    @if(request()->routeIs('home'))
        bar.classList.remove('navbar-dark');
        bar.classList.add('navbar-light');

        if(btnlog) btnlog.classList.replace('text-light', 'text-dark');
        if(btnsign) btnsign.classList.replace('text-light', 'text-dark');
        if(btndash) btndash.classList.replace('text-light', 'text-dark');
        if(btnlogout) btnlogout.classList.replace('text-light', 'text-dark');
    @endif
});

navbarCollapse.addEventListener('hidden.bs.collapse', function () {

    bar.classList.remove('navbar-expanded');

    if (window.scrollY === 0) {
        @if(request()->routeIs('home'))
            bar.classList.remove('navbar-light');
            bar.classList.add('navbar-dark');

            if(btnlog) btnlog.classList.replace('text-dark', 'text-light');
            if(btnsign) btnsign.classList.replace('text-dark', 'text-light');
            if(btndash) btndash.classList.replace('text-dark', 'text-light');
            if(btnlogout) btnlogout.classList.replace('text-dark', 'text-light');

            // Return to transparent at the top
            bar.classList.remove('bar-down', 'shadow-lg', 'bar-transparent');
        @endif
    } else {
        // Keep the scrolled style if we're not at the top
        bar.classList.add('bar-transparent');
    }
});
</script>
@endpush