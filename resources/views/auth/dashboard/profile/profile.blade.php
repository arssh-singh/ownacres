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
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <div class="position-relative d-inline-block mb-3">
                        <img
                            id="profileImagePreview"
                            src="{{ auth()->user()->profile_image_url }}"
                            alt="{{ auth()->user()->name }}"
                            width="120"
                            height="120"
                            class="rounded-circle img-thumbnail">

                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-2 border-white rounded-circle"></span>

                        <button
                            type="button"
                            class="btn btn-light btn-sm rounded-circle position-absolute bottom-0 end-0 shadow"
                            data-bs-toggle="modal"
                            data-bs-target="#profileImageModal">
                            <i class="bi bi-camera-fill"></i>
                        </button>
                    </div>

                    <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>

                    <a href="{{ route('dealer.profile', ['id' => auth()->user()->id]) }}" class="btn text-info">Preview Profile</a>
                    <br/>

                </div>
                <div class="card-footer text-center bg-light border-0">
                    <small class="text-muted mt-auto d-block">
                        Member since {{ auth()->user()->created_at->format('F Y') }}
                    </small>

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
                        Edit
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
                </div>
                @include('auth.dashboard.profile.editprofilemodal')
                @include('auth.dashboard.profile.otpmodal')
            </div>

            <!-- Security -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" id="headline-bio-container">
                <div class="d-flex justify-content-between align-items-center ">
                    <h6 class="fw-bold mb-0">Headline</h6>
                    <button
                        class="btn btn-sm btn-primary"
                        id="edit-headline-bio-btn">
                        Edit
                    </button>
                </div>
                <p class="mb-3">
                    {{ auth()->user()->profile->headline ?? 'No Headline available.' }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Bio</h6>
                </div>
                <p>
                    {{ auth()->user()->profile->bio ?? 'No bio available.' }}
                </p>
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
                formData.append('profile_image', blob, 'avatar.png');

                fetch("{{ route('dashboard.profile.image.update') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileImagePreview').src =
                            data.profile_image_url + '?' + Date.now(); // prevent cache

                        const modalElement = document.getElementById('profileImageModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);

                        if (modal) {
                            modal.hide();
                        }
                    }
                });

            }, 'image/png');
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
<script>
    editHeadlineAndBioBtn = document.getElementById('edit-headline-bio-btn');
    headlineBioContainer = document.getElementById('headline-bio-container');

    editHeadlineAndBioBtn.addEventListener('click', function() {
        headlineBioContainer.innerHTML = `
            <form id="headlineBioForm">
                <div class="mb-3">
                    <label for="headline" class="form-label">Headline</label>
                    <input type="text" class="form-control" id="headline" name="headline" value="{{ auth()->user()->profile->headline ?? '' }}">
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3">{{ auth()->user()->profile->bio ?? '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        `;
        const headlineBioForm = document.getElementById('headlineBioForm');
        headlineBioForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const response = await fetch("{{ route('dashboard.editHeadlineBio') }}", {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            });
            const data = await response.json();
            if (data.success) {
                headlineBioContainer.innerHTML = "Done! Headline and Bio updated successfully.";
            } else {
                headlineBioContainer.innerHTML = "Error updating Headline and Bio.";
            }
        });
    });

</script>
@endpush
