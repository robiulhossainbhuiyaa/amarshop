@extends('front.layouts.app')

@section('contant')
 





 <!-- <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}"> -->
<!-- ***** Men Area Starts ***** -->
<section class="section mt-2" id="">
<div class="auth-wrapper">

    <div class="auth-card">


        <!-- =========================
             BRAND
        ========================== -->

        <div class="brand-area">

            <img src="{{ asset('assets/images/b2.png') }}"
                 alt="Bhuiya Shop">

            <h4>Bhuiya Shop</h4>

            <p>Shop smarter. Live better.</p>

        </div>


        <!-- =========================
             LOGIN FORM
        ========================== -->

        <div id="loginSection">

            <div class="welcome-box">

                <h2>Welcome Back 👋</h2>

                <p> Please login to your account </p>

            </div>

  
            <form method="POST"
                id="signupForm"
                action="{{ route('login_submit') }}">

                @csrf


                <!-- Email -->

                <div class="form-group">

                    <label>Email Address</label>

                    <div class="input-box">

                        <i class="fa fa-envelope left-icon"></i>

                        <input type="email"
                               name="email"
                               placeholder="Enter your email"
                               required>

                    </div>

                </div>


                <!-- Password -->

                <div class="form-group">

                    <label>Password</label>

                    <div class="input-box">

                        <i class="fa fa-lock left-icon"></i>

                        <input type="password"
                               id="loginPassword"
                               name="password"
                               placeholder="Enter your password"
                               required>

                        <i class="fa fa-eye password-toggle"
                           onclick="togglePassword('loginPassword', this)">
                        </i>

                    </div>

                </div>


                <!-- Remember / Forgot -->

                <div class="extra-row">

                    <label class="remember-box">

                        <input type="checkbox"
                               name="remember">

                        Remember me

                    </label>

                    <a href="#"
                       class="forgot-link">

                        Forgot Password?

                    </a>

                </div>


                <!-- Login -->

                <button type="submit"  id="submitbutton"  class="auth-btn"> <i class="fa fa-right-to-bracket me-2"></i>
                    Login 
                </button>
 
                <img src="{{ asset('assets/images/loading.gif') }}"  class="float-right" id="loadImage"  style="display:none;"  />
                 
            </form>


            <div class="switch-text">

                @if(session()->has('msg'))
                    <div class="alert alert-danger">
                        {{ session('msg') }}
                    </div>
                @endif
  
            </div>


            <div class="switch-text">

                Don't have an account?

                <button class="switch-btn"
                        onclick="showRegister()">

                    Register Now

                </button>

            </div>

        </div>


        <!-- =========================
             REGISTER FORM
        ========================== -->

        <div id="registerSection"
             class="hidden">

            <div class="welcome-box">

                <h2>Create Account ✨</h2>

                <p>
                    Join Bhuiya Shop today
                </p>

            </div>


            <form method="POST"
                  action="{{ url('register') }}">

                @csrf


                <!-- Name -->

                <div class="form-group">

                    <label>Full Name</label>

                    <div class="input-box">

                        <i class="fa fa-user left-icon"></i>

                        <input type="text"
                               name="name"
                               placeholder="Enter your full name"
                               required>

                    </div>

                </div>


                <!-- Email -->

                <div class="form-group">

                    <label>Email Address</label>

                    <div class="input-box">

                        <i class="fa fa-envelope left-icon"></i>

                        <input type="email"
                               name="email"
                               placeholder="Enter your email"
                               required>

                    </div>

                </div>


                <!-- Phone -->

                <div class="form-group">

                    <label>Phone Number</label>

                    <div class="input-box">

                        <i class="fa fa-phone left-icon"></i>

                        <input type="text"
                               name="phone"
                               placeholder="01XXXXXXXXX"
                               required>

                    </div>

                </div>


                <!-- Password -->

                <div class="form-group">

                    <label>Password</label>

                    <div class="input-box">

                        <i class="fa fa-lock left-icon"></i>

                        <input type="password"
                               id="registerPassword"
                               name="password"
                               placeholder="Create a password"
                               required>

                        <i class="fa fa-eye password-toggle"
                           onclick="togglePassword('registerPassword', this)">
                        </i>

                    </div>

                </div>


                <!-- Confirm Password -->

                <div class="form-group">

                    <label>Confirm Password</label>

                    <div class="input-box">

                        <i class="fa fa-lock left-icon"></i>

                        <input type="password"
                               id="confirmPassword"
                               name="password_confirmation"
                               placeholder="Confirm your password"
                               required>

                        <i class="fa fa-eye password-toggle"
                           onclick="togglePassword('confirmPassword', this)">
                        </i>

                    </div>

                </div>


                <!-- Register -->

                <button type="submit"
                        class="auth-btn">

                    <i class="fa fa-user-plus me-2"></i>

                    Create Account

                </button>


            </form>


            <div class="back-login">

                <button onclick="showLogin()">

                    <i class="fa fa-arrow-left me-1"></i>

                    Back to Login

                </button>

            </div>

        </div>


        <div class="terms">

            By continuing, you agree to our
            Terms & Conditions and Privacy Policy.

        </div>


    </div>

</div>
</section>



<!-- ***** Men Area Ends ***** -->
 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    @if(session()->has('msg')) 
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Notice',
                    text: "{{ session('msg') }}",
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

<script>  


    $(document).ready(function () {

        $('#signupForm').on('submit', function (e) {
            processData(1);

            e.preventDefault();

            const frm = $(this);

            Swal.fire({
                title: 'Checking your account...',
                text: 'Please wait while we verify your login details.',
                icon: 'info', 
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                timer: 30000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: frm.attr('action'),
                type: 'POST',
                data: frm.serialize(),
                dataType: 'json',

                success: function (data) {
                    processData(0);

                    if (data.stts === 'OK') {
                        Swal.fire({
                            title: "Login Success!",
                            text: data.msg,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        }).then(() => {

                            window.location.href = data.redirect;

                        });
                        
                    }

                    else if (data.stts === 'OTP') {
                        window.location.href = data.redirect;
                    }

                    else {
                        Swal.fire({
                            title: 'Oops!',
                            text: data.msg,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                },

                /*  

                error: function (xhr) {

                    console.log(xhr.responseText);

                    let msg = 'Something went wrong.';

                    if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: msg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
                */
            });

        });

    });



    
    
    function processData(act){
        if(act == 1){
        $('#submitbutton').css('display', 'none');
        $('#loadImage').css('display', 'block');
        }
        else{
        $('#submitbutton').css('display', 'block')
        $('#loadImage').css('display', 'none');
        }
    }
</script>



 

<script>

    function togglePassword(inputId, icon) {

        const input = document.getElementById(inputId);

        if (input.type === "password") {

            input.type = "text";

            icon.classList.remove("fa-eye");

            icon.classList.add("fa-eye-slash");

        } else {

            input.type = "password";

            icon.classList.remove("fa-eye-slash");

            icon.classList.add("fa-eye");

        }

    }


    function showRegister() {

        document.getElementById("loginSection")
            .classList.add("hidden");

        document.getElementById("registerSection")
            .classList.remove("hidden");

    }


    function showLogin() {

        document.getElementById("registerSection")
            .classList.add("hidden");

        document.getElementById("loginSection")
            .classList.remove("hidden");

    }

</script>

 





     

 @endsection