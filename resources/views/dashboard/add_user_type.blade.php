<!-- edit_user_type -->
<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">  
<!-- STYLE CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/addEditPage.css') }}">
 
<script type="text/javascript">   

    var frm = $('#add_dashboard_menu'); 
    frm.on('submit', function(e) { 

        e.preventDefault();

        processData(1);

        var fd = new FormData(this);

        $.ajax({

            url: frm.attr('action'),

            type: 'POST',

            data: fd,

            dataType: 'json',

            processData: false,

            contentType: false,

            success: function(data) {

                processData(0);

                if (data.stts === "OK") {

                    Swal.fire({
                        title: "Success!",
                        text: data.msg,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {

                        reloadDashboardBody();

                    });

                } else {

                    // Validation / server error
                    Swal.fire({
                        title: "Please check the form!",
                        html: data.msg,
                        icon: "error",
                        confirmButtonText: "OK"
                    });

                    $('#success_view').hide();
                }
            },

            error: function(xhr) {

                processData(0);

                let message = "Something went wrong.";

                if (xhr.responseJSON) {

                    message =
                        xhr.responseJSON.msg ||
                        xhr.responseJSON.message ||
                        message;
                }

                Swal.fire({
                    title: "Error!",
                    html: message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }

        });

    });
 
    function processData(act) {
    	if (act == 1) {
    		$('#submitbutton').css('display', 'none');
    		$('#loadImage').css('display', 'block');
    	} else {
    		$('#submitbutton').css('display', 'block');
    		$('#loadImage').css('display', 'none');
    	}
    }

 



    function reloadDashboardBody() 
    {

    
        $('#myPage').modal('hide');
        $('#myPagexl').modal('hide');

        
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');

        
        $('#dashboardBodyLoad').html(`
            <div class="text-center p-5">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Loading... <img src="{{ asset('assets/images/loading.gif') }}"  />
                </p>
            </div>
        `);

        $.ajax({
            url: window.location.href,
            type: 'GET',

            success: function(response) {

                let newBody = $(response)
                    .find('#dashboardBodyLoad')
                    .html();

                $('#dashboardBodyLoad').html(newBody);
            },

            error: function(xhr) {

                Swal.fire({
                    title: 'Error!',
                    text: 'Content reload failed.',
                    icon: 'error'
                });

            }
        });
    }


 
</script>   
 

<section id="sectionsection" class=""> 
    <div class="registration">
        <div class="wrapper"  >
            <div class="inner" >
            
                <form id="add_dashboard_menu" action="{{ route('dashboard.added.user') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf
            
                    <h3><img src="{{ asset('assets/images/b2.png') }}" style="height:25px;"alt=" "> Add User type </h3>
                    <p>safe your all information and account</p> 
                    
                    
                    
                    
                        								

									
                    <div class="form-group">
                        <div class="form-wrapper m-1">
                            <label for="">Type Name</label>
                            <div class="form-holder">
                                
                                <div class="icone">
                                    <i class="fa fa-user-plus icon-gradient bg-ripe-malin "></i>
                                </div>
                                <div class="icone2">
                                    <i class="fa fa-user-plus icon-gradient bg-ripe-malin "></i>
                                </div>
                                <input type="text" class="form-control" name="type_name" id="type_name" value=""  placeholder="Enter Type Name"  >
                                
                            </div>
                        </div>
                        <div class="form-wrapper m-1">
                            <label for="">Type Value</label>
                            <div class="form-holder">
                                
                                <div class="icone">
                                    <i class="fa fa-globe icon-gradient bg-ripe-malin"></i>
                                </div>
                                <div class="icone2">
                                    <i class="fa fa-globe icon-gradient bg-ripe-malin"></i>
                                </div>
                                <input type="text" name="type_value" id="type_value" value="" class="form-control" placeholder="Enter Type Value"  >
                            </div>
                        </div>
                            
                    </div> 		
									
									
                            
                        
                    
                        
                    
                    
                    
                    <div class="form-end">
                        <div class="checkbox">
                            <label> 
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
</section>




 




   

<!-- <section id="sectionsection" class=""> 
    <div class="registration">
        <div class="wrapper" style="background-image: url('assets/images/bg.jpg')">
            <div class="inner" >
            
                <form id="" action="{{ route('dashboard.menu.store') }}" method="POST">
                @csrf

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
</section> -->




 