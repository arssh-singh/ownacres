<div class="position-sticky d-flex flex-column gap-3" style="top: 140px;">

  {{-- Sign up card --}}
    <form action="{{ route('newuser') }}" method="GET">
        <div class="border rounded-4 p-4 bg-white">
            <p class="text-uppercase text-secondary small fw-semibold mb-1" style="letter-spacing:.06em">Get started</p>
            <h2 class="fs-2 fw-medium mb-4">New User?</h2>

            <div class="mb-3">
            <label class="form-label small fw-semibold text-uppercase" style="letter-spacing:.06em">Full name</label>
            <input type="text" class="form-control rounded-3 bg-light border-0" name="name" placeholder="Good Sir Name">
            </div>
            <div class="mb-3">
            <label class="form-label small fw-semibold text-uppercase" style="letter-spacing:.06em">Email</label>
            <input type="email" class="form-control rounded-3 bg-light border-0" name="email" placeholder="your@email.com">
            </div>

            <button class="btn btn-dark w-100 rounded-3 py-2">Create account</button>
            <p class="text-center text-secondary small mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-dark fw-semibold">Log in</a></p>
        </div>
    </form>

  {{-- Trust card --}}
  <div class="border rounded-4 p-4 bg-white">
    <p class="text-uppercase text-secondary small fw-semibold mb-3" style="letter-spacing:.07em">Why choose us</p>

    @foreach([
      ['ti-shield-check', 'Verified listings',    'Every property is reviewed for accuracy before going live.'],
      ['ti-users',        'Trusted advisors',      'Expert guidance from search to handover.'],
      ['ti-trending-down','Best market prices',    'Homes matched to your budget, no hidden markups.'],
      ['ti-star',         '500+ happy clients',    'Families finding their perfect home, every day.'],
    ] as [$icon, $title, $desc])
    <div class="d-flex align-items-start gap-3 mb-3">
      <div class="border rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px;height:36px">
        <i class="ti {{ $icon }} text-secondary"></i>
      </div>
      <div>
        <p class="fw-medium mb-0 small">{{ $title }}</p>
        <p class="text-secondary mb-0" style="font-size:12px">{{ $desc }}</p>
      </div>
    </div>
    @endforeach
  </div>

</div>