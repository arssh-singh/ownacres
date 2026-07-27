<style>
    .footer-ownacres {
        background-color: #ffffff;
        color: #00000099;
        border-top: .1px solid #00000015;
    }
    .footer-ownacres a {
        color: #00000099;
        text-decoration: none;
        transition: color .3s ease;
    }
    .footer-ownacres a:hover {
        color: #000000;
    }
    .footer-brand {
        letter-spacing: .5px;
    }
    .footer-divider {
        border-top: .1px solid #00000015;
    }
    .footer-social a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: .1px solid #00000025;
        border-radius: 50%;
        margin-right: 8px;
        transition: all .3s ease;
        color: #000000;
    }
    .footer-social a:hover {
        border-color: #000000;
        background-color: #00000008;
    }
</style>

<footer class="footer-ownacres pt-5 pb-4">
    <div class="container-fluid px-lg-5">
        <div class="row gy-4">
            <!-- Brand -->
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="navbar-brand fw-bold footer-brand text-dark fs-4 d-inline-block mb-3">OWNACRES</a>
                <p class="mb-4" style="max-width: 320px;">
                    Find, list, and manage properties with ease. Your trusted partner in real estate — from first search to final sale.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4 col-md-6">
                <h6 class="text-dark fw-semibold mb-3">Explore</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                    <li class="mb-2"><a href="{{ route('marketplace') }}">Marketplace</a></li>
                    <li class="mb-2"><a href="{{ route('dealers') }}">Dealers</a></li>
                    <li class="mb-2"><a href="#">Education</a></li>
                </ul>
            </div>

            <!-- Account -->
            <div class="col-lg-4 col-md-6">
                <h6 class="text-dark fw-semibold mb-3">Account</h6>
                <ul class="list-unstyled">
                    @guest
                        <li class="mb-2"><a href="{{ route('login') }}">Login</a></li>
                        <li class="mb-2"><a href="{{ route('register.form') }}">Sign Up</a></li>
                    @endguest
                    @auth
                        <li class="mb-2"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="mb-2"><a href="{{ route('dashboard.savedProperties') }}">Saved Properties</a></li>
                        <li class="mb-2"><a href="{{ route('dashboard.chat') }}">Messages</a></li>
                    @endauth

                </ul>
            </div>

            <!-- Contact -->
            {{-- <div class="col-lg-4 col-md-6">
                <h6 class="text-dark fw-semibold mb-3">Get in Touch</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>support@ownacres.com</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>+91 00000 00000</li>
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Punjab, India</li>
                </ul>
            </div> --}}
        </div>

        <div class="footer-divider my-4"></div>

        <div class="row align-items-center">
            <div class="col-md-6 small">
                &copy; {{ date('Y') }} OWNACRES. All rights reserved.
            </div>
            <div class="col-md-6 text-md-end small mt-3 mt-md-0">
                <a href="#" class="me-3">Privacy Policy</a>
                <a href="#" class="me-3">Terms of Service</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>