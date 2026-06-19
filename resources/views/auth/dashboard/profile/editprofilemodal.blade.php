<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <form id="profileForm">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ auth()->user()->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ auth()->user()->email }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary" id="saveBtn">
                        Continue
                    </button>
                     <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </div>

            </form>

        </div>
    </div>
</div>