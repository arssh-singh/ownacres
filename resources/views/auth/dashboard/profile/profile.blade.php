@extends('layouts.user')
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
                    <a href="#" class="small text-decoration-none fw-semibold" style="color: #4f46e5;">
                        Edit <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-4">
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

            <!-- Danger Zone -->
            <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left: 4px solid #ef4444 !important;">
                <h6 class="fw-bold mb-2 text-danger">Danger Zone</h6>
                <p class="text-muted small mb-3">Once you delete your account, there is no going back. Please be certain.</p>
                <a href="#" class="btn btn-outline-danger rounded-3 px-4">Delete Account</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="profileImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Update Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('dashboard.profile.image.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-center">

                    <img id="modalImagePreview"
                         src="{{ auth()->user()->profile_image_url }}"
                         alt="Preview"
                         class="rounded-circle mb-3"
                         style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #f3f4f6;">

                    <div class="mb-2">
                        <label for="profile_image" class="btn btn-outline-dark rounded-pill px-4">
                            <i class="bi bi-upload me-2"></i>Choose Image
                        </label>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*" class="d-none">
                    </div>

                    <p class="text-muted small mb-0">JPG, PNG or WEBP. Max size 2MB.</p>

                    @error('profile_image')
                        <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection