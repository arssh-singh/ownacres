<!-- linear-gradient(180deg, #0094fd89, #000d38ee), -->
<div class="container-fluid px-lg-5 px-md-5 px-xl-5 px-sm-0 py-5 position-relative"
    style="
    background-image: 
    linear-gradient(280deg, #ffffff00, #000000cc), url('{{ asset('storage/images/banner.png') }}');
    background-size: cover;
    background-position: 0% 35%;
">

    <div class="row" style="height:55vh;">
        <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12 mt-lg-5 mt-sm-0 ">
            <p style="color: white">DISCOVER. CHOOSE. OWN</p>
            <hr style="width: 5%; color:white"/>
            <h1 class="display-3 fw-bold text-white m-0"
                style="text-shadow:0 1px 20px #00000087;">
                Find a place you'll<br/> <span style="color: royalblue !important;">love</span> to live
            </h1>

            <p class="lead fs-6 mb-0"
                style="color:#ffffffc9; ">
                Explore hand-picked properties in the most desirable locations.<br/>
                Your dream home is just a few clicks away.
            </p>
            <!-- action buttons -->
            <div class="mt-4">
                <a href="#"
                    class="btn btn-primary rounded-pill py-3 px-5 me-3">
                    Get Started
                </a>
                <a href="#"
                    class="btn btn-outline-light rounded-pill py-3 px-5">
                    Learn More
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-4 col-md-4 d-none d-lg-flex d-md-flex align-items-center justify-content-end">
            <div class="p-4 rounded-4" style="
                background: rgba(255,255,255,0.12);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255,255,255,0.25);
                width: 100%;
                max-width: 300px;
                color: #fff;
            ">
                <p class="text-uppercase mb-1" style="font-size:11px; letter-spacing:.08em; color:rgba(255,255,255,.6)">
                    India's #1 marketplace
                </p>
                <h2 class="fw-medium mb-4" style="font-size:20px; line-height:1.3">
                    Find your perfect property today
                </h2>

                <div class="row g-2 mb-4">
                    @foreach([
                        ['12k+', 'Active listings'],
                        ['500+', 'Happy clients'],

                    ] as [$num, $label])
                    <div class="col-6">
                        <div class="rounded-3 p-2" style="background:rgba(255,255,255,.1); border:0.5px solid rgba(255,255,255,.2)">
                            <div class="fw-medium" style="font-size:20px">{{ $num }}</div>
                            <div style="font-size:11px; color:rgba(255,255,255,.55)">{{ $label }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <hr style="border-color:rgba(255,255,255,.15)" class="p-0 m-0 mb-1">

                @foreach([
                    ['ti-lock',         'Secure & trusted platform'],
                    ['ti-headset',      'Expert support 7 days a week'],
                ] as [$icon, $text])
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="ti {{ $icon }}" style="font-size:15px; color:rgba(255,255,255,.55)"></i>
                    <span style="font-size:13px; color:rgba(255,255,255,.8)">{{ $text }}</span>
                </div>
                @endforeach

                <a href="{{ route('marketplace.properties.search') }}" class="btn btn-light w-100 rounded-3 mt-3 fw-medium">
                    Browse properties
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Search Box -->
<div class="container p-0 position-relative" style="margin-top: -50px; z-index: 10;">
    <div class="row justify-content-center">
        <div class="col-lg-11">

            <!-- Search Card -->
            <div class="bg-white shadow-sm rounded-5 p-4 mx-3 mx-md-0">
                <form action="{{ route('marketplace.properties.search') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <!-- Location -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label fw-semibold small mb-1 d-block">Location</label>
                            <div class="d-flex align-items-center border rounded-3 px-3 py-2">
                                <i class="bi bi-geo-alt text-muted me-2"></i>
                                <input type="text" class="form-control border-0 p-0 shadow-none" name="location" placeholder="Enter city or area">
                                <i class="bi bi-geo text-muted ms-2"></i>
                            </div>
                        </div>

                        <!-- Property Type -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label fw-semibold small mb-1 d-block">Property Type</label>
                            <div class="d-flex align-items-center border rounded-3 px-3 py-2">
                                <i class="bi bi-house text-muted me-2"></i>
                                <select class="form-select border-0 p-0 shadow-none text-muted" name="property_type">
                                    <option>All Types</option>
                                    <option>House</option>
                                    <option>Apartment</option>
                                    <option>Villa</option>
                                    <option>Plot</option>
                                </select>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <label class="form-label fw-semibold small mb-1 d-block">Price Range</label>
                            <div class="d-flex align-items-center border rounded-3 px-3 py-2">
                                <i class="bi bi-tag text-muted me-2"></i>
                                <select class="form-select border-0 p-0 shadow-none text-muted" name="price_range">
                                    <option value="">Any Price</option>
                                    <option value="Under 50 Lac">Under 50 Lac</option>
                                    <option value="50 Lac - 1 Crore">50 Lac - 1 Crore</option>
                                    <option value="1 Crore - 2 Crore">1 Crore - 2 Crore</option>
                                    <option value="Over 2 Crore">Over 2 Crore</option>
                                </select>
                            </div>
                        </div>

                        <!-- Beds & Baths -->
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12">
                            <label class="form-label fw-semibold small mb-1 d-block">Beds &amp; Baths</label>
                            <div class="d-flex align-items-center border rounded-3 px-3 py-2">
                                <i class="bi bi-door-closed text-muted me-2"></i>
                                <select class="form-select border-0 p-0 shadow-none text-muted" name="bedrooms">
                                    <option>Any</option>
                                    <option>1+</option>
                                    <option>2+</option>
                                    <option>3+</option>
                                    <option>4+</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12">
                            <button class="btn btn-dark rounded-3 w-100 py-2 fw-semibold mt-4">
                                <i class="bi bi-search me-1"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
