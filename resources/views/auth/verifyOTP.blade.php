@extends('layouts.app')
@section('content')
<div class="container mt-5 mb-5 pt-5">
    <div class="col-md-5 mx-auto">
        <div class="card p-4 border-0 bg-light">

            <h3 class="mb-3 text-center">Verify OTP</h3>
            <p>
                OTP expires in
            <span id="timer"></span>
            </p>

            <!-- ERROR DISPLAY -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.verifyOtp') }}">
                @csrf
                
                <div class="mb-3">
                    <label>Enter OTP</label>
                    <input class="form-control" type="text" name="otp">
                </div>

                <button id="verifyBtn" type="submit" class="btn btn-primary">
                    Verify OTP
                </button>
            </form>
                <form action="{{ route('register.resendOtp') }}" method="POST">
                    @csrf

                    <button
                        id="resendBtn"
                        class="btn btn-outline-primary"
                        disabled
                    >
                        Resend OTP
                    </button>
                </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
const expiresAt = {{ \Carbon\Carbon::parse($expiresAt)->timestamp }};

function updateTimer() {
    const now = Math.floor(Date.now() / 1000);
    let remaining = expiresAt - now;

    if (remaining <= 0) {
        document.getElementById('timer').textContent = "Expired";
        clearInterval(interval);

        document.getElementById('verifyBtn').disabled = true;
        document.getElementById('resendBtn').disabled = false;

        return;
    }

    const minutes = Math.floor(remaining / 60);
    const seconds = remaining % 60;

    document.getElementById('timer').textContent =
        `${minutes}:${String(seconds).padStart(2, '0')}`;
}

updateTimer();
const interval = setInterval(updateTimer, 1000);
</script>
@endpush