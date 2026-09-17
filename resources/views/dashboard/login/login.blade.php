@extends('front.layouts.app')

@section('contant')
 




 


    <!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">  
		  
		<section id="sectionsection" class=""> 
			<div class="registration">
				<div class="wrapper" style="background-image: url('assets/images/bg.jpg')">
					<div class="inner"> 












                        <div id="loginSection">
                            <form method="POST" id="signupForm" action="{{ route('login_submit') }}">

                                @csrf
                                <h3><img src="{{ asset('assets/images/b2.png') }}" style="height:25px;"alt=" "> Please login to your account</h3>
                                <p>safe your all information and account</p> 
                                <div class="form-group">
                                    <div class="form-wrapper">
                                        <label for="">Email:</label>
                                        <div class="form-holder">
                                            
                                            <div class="icone">
                                                <i class="fa fa-envelope  icon-gradient bg-plum-plate"></i>
                                            </div> 
                                            <input type="text" name="email" id="email" value="" class="form-control" placeholder="your@email.com"  >
                                        </div>
                                    </div>  
                                </div>
                                <div class="form-group">  
                                    <div class="form-wrapper">
                                        <label for="">Password:</label>
                                        <div class="form-holder">
                                            
                                            <div class="icone">
                                                <i class="fa fa-lock icon-gradient bg-happy-itmeo"></i>
                                            </div>
                                            <div class="icone2">
                                                <i id="toggleIcon" onclick="togglePassword('loginPassword', this)" class="fa fa-eye icon-gradient bg-happy-itmeo" style="cursor: pointer;"></i>
                                            </div>
                                            <input type="password" name="password" id="loginPassword" value="" class="form-control" placeholder="Enter Password"  >
                                        </div>
                                    </div> 
                                </div>
                                
                                
                                
                                <div class="form-end">
                                    <div class="checkbox">
                                        <label>
                                            
                                            <b>Don't have an account? </b> <a href="javascript:void(0)" onclick="showRegister()"><strong> Register here</strong></a>
                                            <a href="termsofuse"><strong> Terms of use.</strong></a> 
                                            <a href="privacypolicy"><strong> Privacy policy</strong></a>
                                            
                                        </label>
                                    </div>
                                    <div class="button-holder " >
                                        <button data-style="zoom-out" class="ladda-button ladda-label" id="submitbutton" type="submit" >
                                            <i class="fa fa-right-to-bracket mr-1"></i> 
                                            Log in
                                        </button>
                                        <img src="{{ asset('assets/images/loading.gif') }}" style="display:none;" class="float-right" id="loadImage"/>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">  
                                    <div class="form-wrapper">

                                        @if(session()->has('msg'))
                                            <div class="alert alert-danger">
                                                {{ session('msg') }}
                                            </div>
                                        @endif
                        
                                    </div> 
                                </div>
                                
                                
                            </form>
                        </div>







                        



                        <div id="registerSection" class="hidden" >

                            <form method="POST" id="" action="">

                                @csrf
                                <h3><img src="{{ asset('assets/images/b2.png') }}" style="height:25px;"alt=" "> Create Account </h3>
                                <p>safe your all information and account</p> 
                                
                                
                                
                                
                                    <div class="form-group">
										
										<div class="form-wrapper m-1">
											<label for="">Full Name</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa fa-user-plus icon-gradient bg-ripe-malin"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-user-plus icon-gradient bg-ripe-malin"></i>
												</div>
												<input type="text" name="firstname" id="firstname" value="" class="form-control" placeholder="Enter Your Name"  >
											</div>
										</div>

                                        <div class="form-wrapper m-1">
											<label for="">Username</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa-regular fa-circle-user"></i>
												</div>
												<div class="icone2">
													<i class="fa-regular fa-circle-user"></i>
												</div>
												<input type="text" class="form-control" name="username" readonly id="username" value=""  placeholder="auto create username"  >
											 
											</div>
										</div>
										 
									</div>
									
									<div class="form-group">
										<div class="form-wrapper m-1">
											<label for="">Email</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa fa-envelope  icon-gradient bg-plum-plate"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-envelope  icon-gradient bg-plum-plate"></i>
												</div>
												<input type="text" name="email" id="email" value="" class="form-control" placeholder="your@email.com"  >
											</div>
										</div> 
										
										<div class="form-wrapper m-1">
											<label for="">Phone Number</label>
										 
											<div class="form-holder">
												<div class="icone">
													<i class="fa fa-phone icon-gradient bg-malibu-beach"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-phone icon-gradient bg-malibu-beach"></i>
												</div>
												<input type="text" name="phonenumber" id="phonenumber" value="" class="form-control" placeholder="Enter Your Phone Number"  >
											</div>
										</div>
										
										
									</div>
									
									<div class="form-group">
										<div class="form-wrapper m-1">
											<label for="">Password</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa fa-lock icon-gradient bg-happy-itmeo"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-lock icon-gradient bg-happy-itmeo"></i>
												</div>
												<input type="text" name="password" id="password" value="" class="form-control" placeholder="Enter Password"  >
											</div>
										</div>
										
										<div class="form-wrapper m-1">
											<label for="">Confirm Password</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa fa-lock icon-gradient bg-happy-itmeo"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-lock icon-gradient bg-happy-itmeo"></i>
												</div>
												<input type="text" name="repassword" id="repassword" value="" class="form-control" placeholder="Enter Confirm Password"  >
											</div>
										</div>
										
										
										
									</div>
									
									<div class="form-group">
										<div class="form-wrapper m-1">
											<label for="">Address</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa fa-home icon-gradient bg-sunny-morning"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-home icon-gradient bg-sunny-morning"></i>
												</div>
												<input type="text" name="address1" id="address1" value="" class="form-control" placeholder="Enter Address"  >
											</div>
										</div>
										
										<div class="form-wrapper m-1">
											<label for="">City</label>
											<div class="form-holder">
												
												<div class="icone">
													<i class="fa fa-city"></i>
												</div>
												<div class="icone2">
													<i class="fa fa-city"></i>
												</div>
												<input type="text" name="city" id="city" value="" class="form-control" placeholder="Enter City Name:"  >
											</div>
										</div> 
									</div>
									 
									
									
									<div class="form-group">
										<div class="form-wrapper m-1">
											<label for="">Select Country/Region </label>
										
											<div class="form-holder ">
												
												<div class="icone">
													<i class="fa fa-globe"></i>
												</div> 
												<select name="country" id="country" class="form-control"  >
													<option value=""  >Select Country</option>
													 
                                                    <option value="1"> bd</option> 
												</select>
											</div>
										</div>
										
										<div class="form-wrapper m-1">
											<label for="">Which one will you choose?</label>
										
											<div class="form-holder ">
												
												<div class="icone">
													<i class="fa fa-users icon-gradient bg-amy-crisp"></i>
												</div>
												 
												<select name="user_type" id="user_type" class="form-control"  >
													<option value=""  >Select choose</option>
													<option value=""  >Customer</option>
													<option value=""  >Delivery boy</option>
													 
												</select>
											</div>
										</div>
										
									</div>
									
                                
                                
                                
                                <div class="form-end">
                                    <div class="checkbox">
                                        <label>
                                            
                                            <b>already have an account.</b> 
                                            <a href="javascript:void(0)" onclick="showLogin()"><strong>Back to Login</strong></a>
                                             
                                            <a href="termsofuse"><strong> Terms of use.</strong></a> 
                                            <a href="privacypolicy"><strong> Privacy policy</strong></a>
                                            
                                        </label>
                                    </div>
                                    <div class="button-holder " >
                                        <button data-style="zoom-out" class="ladda-button ladda-label" id="submitbutton" type="submit" >
                                            <i class="fa fa-right-to-bracket mr-1"></i> 
                                            Create
                                        </button>
                                        <img src="{{ asset('assets/images/loading.gif') }}" style="display:none;" class="float-right" id="loadImage"/>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">  
                                    <div class="form-wrapper">

                                        @if(session()->has('msg'))
                                            <div class="alert alert-danger">
                                                {{ session('msg') }}
                                            </div>
                                        @endif
                        
                                    </div> 
                                </div>
                                
                                
                            </form>

                        </div> 





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