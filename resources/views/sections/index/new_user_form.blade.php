<div class="position-sticky d-flex flex-column gap-3 " style="top: 140px;">

  {{-- Sign up card --}}
    <form action="{{ route('newuser') }}" method="GET">
        <div class="border rounded-4 p-4 bg-white">
            <p class="text-uppercase text-secondary small fw-semibold mb-1" style="letter-spacing:.06em">Get started</p>
            <h2 class="fs-2 fw-medium mb-4">New User?</h2>

            <div class="mb-3">
            <label class="form-label small fw-semibold text-uppercase" style="letter-spacing:.06em">Full name</label>
            <input type="text" class="form-control rounded-3 bg-light border-0" name="name" placeholder="Name">
            </div>
            <div class="mb-3">
            <label class="form-label small fw-semibold text-uppercase" style="letter-spacing:.06em">Email</label>
            <input type="email" class="form-control rounded-3 bg-light border-0" name="email" placeholder="your@email.com">
            </div>

            <button class="btn btn-dark w-100 rounded-3 py-2">Create account</button>
            <p class="text-center text-secondary small mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-dark fw-semibold">Log in</a></p>
        </div>
    </form>

{{-- About card --}}
<div class="border rounded-4 p-5 bg-white">
  <p class="text-uppercase text-secondary fw-semibold mb-3" style="letter-spacing:.07em; font-size:13px;">About OWNACRES</p>

  <p class="text-secondary mb-0" style="font-size:16px; line-height:1.8;">
    OWNACRES is a real estate platform built to make finding and managing property simple. We connect buyers, sellers, and dealers on one trusted space, bringing clarity to a process that's often confusing. Our goal is to remove the guesswork from real estate — giving people the tools and confidence they need to make one of the biggest decisions of their lives.
  </p>
</div>
</div>