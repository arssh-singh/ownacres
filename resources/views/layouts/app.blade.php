<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Ownacres</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        @vite(['resources/css/style.css'])
    </head>

    <body>
        <header>
            @include('partials.navbar')
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="bg-light pt-5 pb-4">
            <div class="container-fluid px-lg-5 pt-5">

                <div class="row gy-4">

                    <!-- Brand -->
                    <div class="col-lg-4">
                        <h5 class="fw-bold">LUXE ARCHIVE</h5>
                        <p class="text-muted mt-3">
                            Redefining the premium real estate journey through absolute clarity and design-led curation.
                        </p>
                    </div>

                    <!-- Company -->
                    <div class="col-lg-2">
                        <h6 class="fw-semibold mb-3">Company</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="footer-link">ABOUT US</a></li>
                            <li><a href="#" class="footer-link">CAREERS</a></li>
                            <li><a href="#" class="footer-link">CONTACT</a></li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div class="col-lg-3">
                        <h6 class="fw-semibold mb-3">Legal</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="footer-link">PRIVACY POLICY</a></li>
                            <li><a href="#" class="footer-link">TERMS OF SERVICE</a></li>
                            <li><a href="#" class="footer-link">COOKIE POLICY</a></li>
                        </ul>
                    </div>

                    <!-- Social -->
                    <div class="col-lg-3">
                        <h6 class="fw-semibold mb-3">Follow Us</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="footer-link">Instagram</a>
                            <a href="#" class="footer-link">LinkedIn</a>
                        </div>
                    </div>

                </div>

                <!-- Divider -->
                <hr class="my-4">

                <!-- Bottom -->
                <div class="text-center text-muted small">
                    © 2024 LUXE ARCHIVE. ALL RIGHTS RESERVED.
                </div>

            </div>
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
