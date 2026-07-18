@extends('layouts.user')
@push('styles')
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">
@endpush
@section('content')
<div class="container-fluid px-lg-5 px-3 mt-5 mb-5">
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Account Settings</h3>
        <p class="text-muted mb-0">View and manage your profile details</p>
    </div>

    <div class="row g-4">
        <!-- Left: Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                <div class="position-relative mx-auto mb-3" style="width: 110px;">
                    <img id="profileImagePreview"
                        src="{{ auth()->user()->profile_image_url }}"
                        alt="Profile Image"
                        class="rounded-circle"
                        style="width: 110px; height: 110px; object-fit: cover; border: 4px solid #f3f4f6;">

                    <!-- Online status dot -->
                    <span class="position-absolute top-0 end-0 bg-success rounded-circle border border-3 border-white"
                        style="width: 18px; height: 18px;"></span>

                    <!-- Edit image button -->
                    <a href="#" class="position-absolute bottom-0 end-0 bg-light rounded-circle border d-flex align-items-center justify-content-center shadow-sm"
                    style="width: 32px; height: 32px; transform: translate(10%, 10%);"
                    data-bs-toggle="modal" data-bs-target="#profileImageModal">
                        <i class="bi bi-camera-fill text-dark" style="font-size: 0.9rem;"></i>
                    </a>
                </div>

                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>

                @if(auth()->user()->email_verified_at)
                    <span class="badge rounded-pill px-3 py-2 fw-normal mx-auto mb-4" style="background: #ecfdf5; color: #059669; width: fit-content;">
                        <i class="bi bi-patch-check-fill me-1"></i> Verified
                    </span>
                @else
                    <span class="badge rounded-pill px-3 py-2 fw-normal mx-auto mb-4" style="background: #fff7ed; color: #ea580c; width: fit-content;">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> Not Verified
                    </span>
                @endif

                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-light border rounded-3 py-2">
                        <i class="bi bi-key me-2"></i>Change Password
                    </a>
                </div>

                <hr class="my-4">

                <div class="row text-center g-2">
                    <div class="col-6 border-end">
                        <h6 class="fw-bold mb-0">{{ auth()->user()->created_at->format('M Y') }}</h6>
                        <small class="text-muted">Joined</small>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold mb-0">{{ ucfirst(auth()->user()->role ?? 'User') }}</h6>
                        <small class="text-muted">Role</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Info Sections -->
        <div class="col-lg-8">
            <!-- Personal Info -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">Personal Information</h6>
                    <button
                        class="btn btn-sm btn-primary"
                        id="edit-profile-btn">
                        Edit Profile
                    </button>
                </div>

                <div class="row g-4" id="profile-view">
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Full Name</small>
                        <p class="fw-semibold mb-0">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Email Address</small>
                        <p class="fw-semibold mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Phone Number</small>
                        <p class="fw-semibold mb-0">{{ auth()->user()->phone ?? '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block mb-1">Location</small>
                        <p class="fw-semibold mb-0">{{ auth()->user()->location ?? '—' }}</p>
                    </div>
                </div>
                @include('auth.dashboard.profile.editprofilemodal')
                @include('auth.dashboard.profile.otpmodal')
            </div>

            <!-- Security -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold mb-4">Security</h6>

                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <p class="fw-semibold mb-0">Password</p>
                        <small class="text-muted">Last changed recently</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-light border rounded-pill px-3">Update</a>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2 border-bottom mt-2">
                    <div>
                        <p class="fw-semibold mb-0">Two-Factor Authentication</p>
                        <small class="text-muted">Add an extra layer of security</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-light border rounded-pill px-3">Enable</a>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2 mt-2">
                    <div>
                        <p class="fw-semibold mb-0">Active Sessions</p>
                        <small class="text-muted">Manage devices logged into your account</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-light border rounded-pill px-3">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Profile Image Modal -->
@include('auth.dashboard.profile.profileimagemodal')
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
<script>
    const profileImageInput = document.getElementById('profileImageInput');
    const cropperImage = document.getElementById('cropperImage');
    const cropImageButton = document.getElementById('cropImageButton');
    let cropper;

    profileImageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                cropperImage.src = e.target.result;
                cropperImage.style.display = 'block';
                cropImageButton.style.display = 'block';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });
    cropImageButton.addEventListener('click', function () {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });

            canvas.toBlob(function (blob) {
                const formData = new FormData();
                formData.append('profile_image', blob, 'profile_image.png');

                fetch("{{ route('dashboard.profile.image.update') }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileImagePreview').src = data.profile_image_url;
                        $('#profileImageModal').modal('hide');
                    } else {
                        alert('Failed to update profile image.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the profile image.');
                });
            });
        }
    });
</script>
<script>
    // ─── DOM References ───────────────────────────────────────────────────────────

    const editProfileBtn   = document.getElementById('edit-profile-btn');
    const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
    const profileForm      = document.getElementById('profileForm');
    const saveBtn          = document.getElementById('saveBtn');
    const btnSpinner       = document.getElementById('btnSpinner');

    const otpForm          = document.getElementById('otpForm');
    const verifyBtn        = document.getElementById('verifyBtn');
    const verifySpinner    = document.getElementById('verifybtnSpinner');
    const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));

    // ─── Helpers ──────────────────────────────────────────────────────────────────

    function setLoading(btn, spinner, isLoading) {
        btn.classList.toggle('d-none', isLoading);
        spinner.classList.toggle('d-none', !isLoading);
    }

    async function postForm(url, formData) {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        return response.json();
    }

    // ─── Open Edit Profile Modal ──────────────────────────────────────────────────

    editProfileBtn.addEventListener('click', () => editProfileModal.show());

    // ─── Submit Profile Form (request OTP) ────────────────────────────────────────

    profileForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        setLoading(saveBtn, btnSpinner, true);

        const data = await postForm("{{ route('dashboard.editProfile') }}", new FormData(this));

        if (data.success) {
            editProfileModal.hide();
            otpModal.show();
        }

        setLoading(saveBtn, btnSpinner, false);
    });

    // ─── Submit OTP Form ──────────────────────────────────────────────────────────

    otpForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        setLoading(verifyBtn, verifySpinner, true);

        const data = await postForm("{{ route('dashboard.editProfile.checkOtp') }}", new FormData(this));

        if(data.success == false){
            const message = document.getElementById('otpError')
            message.classList.remove('d-none')
        }
        else{
            otpModal.hide();
        }

        setLoading(verifyBtn, verifySpinner, false);
    });
</script>
@endpush
