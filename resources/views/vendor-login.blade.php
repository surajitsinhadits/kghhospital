<!DOCTYPE html>
<html>
@php
    if(Session::get('login_id')) {
        header('Location: ' . route('vendor-dashboard'));
        exit();
    }
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('public/favicon.png') }}" type="image/x-icon" />
    <title>{{ hospital('title') }} Hospital</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" referrerpolicy="no-referrer" />
    <link href="{{ url('public/login.css') }}" rel="stylesheet" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <!-- =============================login here========================== -->
    <div class="login_outerarea">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="overlay_backdesign">
                        <div class="wrap-login100">
                            <form method="POST" action="{{ Route('check-vendor') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="color: white;">Vendor Login</h4>
                                    </div>
                                </div>
                                <div class="material-textfield">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                                    <label for="email">Enter Your Email</label>
                                    <i class="fas fa-envelope icondesign"></i>
                                    <small class="text-danger"></small>
                                </div>
                                <div class="material-textfield">
                                    <input type="password" id="id_password" name="password" autocomplete="current-password">
                                    <label for="email">Enter Your Password</label>
                                    <i class="fas fa-unlock-alt icondesign"></i>
                                    <i class="fas fa-eye icondesign1" id="togglePassword"></i>
                                    <small class="text-danger"></small>
                                </div>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" style="color: linen;">Forgot Password?</a>
                                <div class="lgnbtn_outerarea">
                                    <button class="another_btndesign">
                                        LOG IN
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forgot Password Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-3">
                        <form id="forgotPasswordForm">
                            <label class="form-label">Enter Email</label>
                            <input type="email" placeholder="Enter Email" class="form-control" id="forgotEmail" required>
                            <button type="button" class="btn btn-primary mt-2" id="sendOtp">Send OTP</button>
                        </form>

                        <form id="otpForm" class="d-none">
                            <label class="form-label">Enter OTP</label>
                            <input type="text" placeholder="Enter OTP" class="form-control" id="otpCode" required>
                            <button type="button" class="btn btn-success mt-2" id="verifyOtp">Verify OTP</button>
                        </form>

                        <form id="resetPasswordForm" class="d-none">
                            <label class="form-label">New Password</label>
                            <input type="password" placeholder="Enter New Password" class="form-control" id="newPassword" required>
                            <button type="button" class="btn btn-danger mt-2" id="resetPassword">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- =============================login here========================== -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
        @elseif(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
        @endif

        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#id_password');
            togglePassword.addEventListener('click', function(e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password'; // toggle the type attribute
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash'); // toggle the eye slash icon
            });

            $("#sendOtp").click(function() {
                let email = $("#forgotEmail").val();
                $.post("{{ route('send-otp') }}", {
                    email: email,
                    _token: "{{ csrf_token() }}"
                }, function(response) {
                    alert(response.message);
                    if (response.status) {
                        $("#forgotPasswordForm").hide();
                        $("#otpForm").removeClass("d-none");
                    }
                });
            });

            $("#verifyOtp").click(function() {
                let otp = $("#otpCode").val();
                $.post("{{ route('verify-otp') }}", {
                    otp: otp,
                    _token: "{{ csrf_token() }}"
                }, function(response) {
                    alert(response.message);
                    if (response.status) {
                        $("#otpForm").hide();
                        $("#resetPasswordForm").removeClass("d-none");
                    }
                });
            });

            $("#resetPassword").click(function() {
                let password = $("#newPassword").val();
                $.post("{{ route('reset-password') }}", {
                    password: password,
                    _token: "{{ csrf_token() }}"
                }, function(response) {
                    alert(response.message);
                    if (response.status) {
                        location.reload();
                    }
                });
            });
        </script>
</body>

</html>
