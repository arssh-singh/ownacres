<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <!-- SEO -->
        <title>@yield('title', 'OwnAcres | Buy, Sell & Rent Properties')</title>
        <meta
            name="description"
            content="@yield('description', 'Find properties for sale and rent across India with OwnAcres.')"
        >

        <meta
            name="keywords"
            content="@yield('keywords', 'real estate, properties, buy property, sell property, rent property, OwnAcres')"
        >

        <meta
            name="robots"
            content="@yield('robots', 'index,follow')"
        >

        <link
            rel="canonical"
            href="@yield('canonical', url()->current())"
        >

        <!-- Open Graph -->
        <meta property="og:type" content="@yield('og_type', 'website')">

        <meta
            property="og:title"
            content="@yield('og_title', View::yieldContent('title', 'OwnAcres | Buy, Sell & Rent Properties'))"
        >

        <meta
            property="og:description"
            content="@yield('og_description', View::yieldContent('description', 'Find properties for sale and rent across India with OwnAcres.'))"
        >

        <meta
            property="og:url"
            content="@yield('og_url', url()->current())"
        >

        <meta
            property="og:image"
            content="@yield('og_image', asset('images/og-default.jpg'))"
        >

        <meta property="og:site_name" content="OwnAcres">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">

        <meta
            name="twitter:title"
            content="@yield('twitter_title', View::yieldContent('title', 'OwnAcres | Buy, Sell & Rent Properties'))"
        >

        <meta
            name="twitter:description"
            content="@yield('twitter_description', View::yieldContent('description', 'Find properties for sale and rent across India with OwnAcres.'))"
        >

        <meta
            name="twitter:image"
            content="@yield('twitter_image', asset('images/og-default.jpg'))"
        >
        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset("storage/images/logo.png") }}">

        {{-- <link href="{{ asset('/resources/css/style.css')  }}" rel="stylesheet"> --}}

        {{-- @vite(['resources/css/style.css']) --}}
        @stack('styles')
    </head>

    <body>
        <header>
            @include('partials.navbar')
        </header>
        <main>
            @yield('content')
        </main>
        @include('partials.footer')
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>

        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"
        ></script>
        @stack('scripts')
    </body>
</html>
