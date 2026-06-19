<div class="modal fade" id="otpModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title">
                    Verify OTP
                </h5>
            </div>

            <form id="otpForm">
                @csrf

                <div class="modal-body">
                    <div id="otpError" class="alert alert-danger d-none" role="alert">
                        OTP is incorrect.
                    </div>
                    <p class="text-muted">
                        Enter the OTP sent to your email.
                    </p>

                    <input
                        type="text"
                        name="otp"
                        class="form-control"
                        placeholder="Enter OTP">

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary" id="verifyBtn">
                        Verify
                    </button>
                    <span id="verifybtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </div>

            </form>

        </div>
    </div>
</div>