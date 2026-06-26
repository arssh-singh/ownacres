<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <title>Ownacres</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    {{-- <link href="resources/css/style.css"> --}}
    @vite(['resources/css/style.css'])
    @stack('styles')
</head>

<body>

    <!-- NAVBAR -->
    <header>
        @include('partials.navbar')
    </header>

    <!-- MOBILE SIDEBAR -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas">
            </button>
        </div>

        <div class="offcanvas-body">
            @include('partials.sidebar')
        </div>

    </div>

    <!-- PAGE CONTENT -->
    <div class="container-fluid mt-5 pt-3">
        <div class="row">

            <!-- DESKTOP SIDEBAR -->
            <aside class="col-lg-3 d-none d-lg-block">
                @include('partials.sidebar')
            </aside>

            <!-- MAIN CONTENT -->
            <main class="col-12 col-lg-9">
                @yield('content')
            </main>

        </div>
    </div>
    
    <button
        class="btn btn-primary position-fixed d-lg-none "
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#mobileSidebar"
        style="
            bottom: 20px;
            left: 20px;
            z-index: 1050;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        ">
        <i class="bi bi-list"></i>
    </button>

    <!-- FOOTER -->
    <footer class="bg-light pt-5 pb-4 mt-auto">
        <div class="container-fluid px-lg-5">

            <div class="row gy-4">

                <div class="col-lg-4">
                    <h5 class="fw-bold">OWNACRES</h5>
                    <p class="text-muted mt-3">
                        Redefining the premium real estate journey through clarity and design-led curation.
                    </p>
                </div>

                <div class="col-lg-2">
                    <h6 class="fw-semibold mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">ABOUT US</a></li>
                        <li><a href="#" class="footer-link">CAREERS</a></li>
                        <li><a href="#" class="footer-link">CONTACT</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-semibold mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">PRIVACY POLICY</a></li>
                        <li><a href="#" class="footer-link">TERMS</a></li>
                        <li><a href="#" class="footer-link">COOKIES</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-semibold mb-3">Follow</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-link">Instagram</a>
                        <a href="#" class="footer-link">LinkedIn</a>
                    </div>
                </div>

            </div>

            <hr class="my-4">

            <div class="text-center text-muted small">
                © 2026 LUXE ARCHIVE. ALL RIGHTS RESERVED.
            </div>

        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    
</body>
</html>