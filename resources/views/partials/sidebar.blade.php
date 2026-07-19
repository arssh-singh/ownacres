<style>
    .sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 2px;
    padding: 1rem;
    list-style: none;
    margin: 0;
}

.sidebar-nav .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 14px;
    color: #6b7280;
    transition: background 0.15s, color 0.15s;
    text-decoration: none;
}

.sidebar-nav .nav-link:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #111;
}

.sidebar-nav .nav-link.active {
    background: #111;
    color: #fff;
    font-weight: 500;
}

.nav-divider {
    border: none;
    border-top: 1px solid rgba(0,0,0,0.08);
    margin: 0 0 8px;
}

.nav-link--cta {
    border: 1px solid rgba(0,0,0,0.15);
    justify-content: center;
    font-weight: 500;
    color: #111 !important;
}

.nav-link--cta:hover {
    background: rgba(0,0,0,0.05) !important;
}
</style>
<!-- Sidebar -->
<div class="bg-light sidebar h-100" id="sidebar" style="view-transition-name: sidebar;">
    <div class="mb-2 p-4 pb-2">
        <div class="container-fluid text-center p-2">
            
            <!-- Profile Image -->
            <img 
                class="img-fluid rounded-circle mb-2" 
                style="width: 60px; height: 60px; object-fit: cover;" 
                src="{{ auth()->user()->profile_image_url }}" 
                alt="Profile Image"
            />

            <!-- User Info -->
            <p class="mb-0 fw-semibold small">{{ auth()->user()->name }}</p>
            <p class="text-muted small text-truncate">{{ auth()->user()->email }}</p>

        </div>
    </div>

    <ul class="sidebar-nav">
        @php
            $links = [
                ['route' => 'dashboard',              'icon' => 'bi-columns',  'label' => 'Home'],
                ['route' => 'dashboard.profile',       'icon' => 'bi-person',   'label' => 'Profile'],
                ['route' => 'dashboard.chat',       'icon' => 'bi-chat',   'label' => 'Messages'],
                ['route' => 'dashboard.properties',    'icon' => 'bi-houses',   'label' => 'Properties'],
                ['route' => 'dashboard.savedProperties','icon' => 'bi-bookmark', 'label' => 'Saved Properties']
            ];
        @endphp

        @foreach ($links as $link)
            @php $active = request()->routeIs($link['route']); @endphp
            <li class="nav-item">
                <a href="{{ route($link['route']) }}"
                class="nav-link {{ $active ? 'active' : '' }}"
                @if ($active) aria-current="page" @endif>
                    <i class="bi {{ $link['icon'] }}" aria-hidden="true"></i>
                    {{ $link['label'] }}
                </a>
            </li>
        @endforeach

        <li class="nav-item mt-auto pt-3">
            <hr class="nav-divider">
            <a href="{{ route('properties.create') }}" class="nav-link nav-link--cta">
                <i class="bi bi-plus" aria-hidden="true"></i> List New Property
            </a>
        </li>
    </ul>
</div>
