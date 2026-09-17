<!-- view_permission_user -->
<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">  
<!-- STYLE CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/addEditPage.css') }}">
 
<script type="text/javascript">  
    var frm = $('#add_dashboard_menu');

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
 
 
@foreach($pagedata as $datarslt)
<section id="sectionsection" class=""> 
    <div class="registration">
        <div class="wrapper"  >
            <div class="inner" >
            
                <form id="add_dashboard_menu" action="{{ route('dashboard.edit_utype.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf
            
                    <h3><img src="{{ asset('assets/images/b2.png') }}" style="height:25px;"alt=" "> Edit User type </h3>
                    <p>safe your all information and account</p> 
                    <input type="hidden" class="form-control" id="rid" name="rid" value=" {{$rid}} ">
                    
                    
                    
                    
                        								

									
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
                                <input type="text" class="form-control" name="type_name" id="type_name" value="{{$datarslt->type_name}}"  placeholder="Enter Type Name"  >
                                
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
                                <input type="text" name="type_value" id="type_value" value="{{$datarslt->type_value}}" class="form-control" placeholder="Enter Type Value"  >
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
@endforeach  


 