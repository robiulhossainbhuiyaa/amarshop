<!-- STYLE CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/addEditPage.css') }}">
<!-- <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">   -->

 
<script type="text/javascript">  
    var frm = $('#add_dashboard_menu');

    frm.submit(function(e) {

        e.preventDefault();

        processData(1);

        var fd = frm.serialize();

        $.ajax({

            url: frm.attr('action'),

            type: 'POST',

            data: fd,

            dataType: 'json',

            success: function(data) {

                processData(0);

                if (data.stts === "OK") {

                    Swal.fire({
                        title: "Success!",
                        text: data.msg,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        reloadDashboardBody();

                    });

                } else {

                    $('#alert_view')
                        .show()
                        .html(data.msg);

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
                    title: "Please check the form!",
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






    
    function setMenulink(str){
        var linkdata = str.toLowerCase().trim();   
        var linkrepl = linkdata.replace(/\s+/g, "_").replace(/[^a-z0-9_]/g, "");  
        $('#menu_link').val(linkrepl);  
    }

    function setMenuactivites(str){
        if(str == 0){
            $('#sub_menu_serial').val('0').attr('readonly', true);  
            $('#menu_serial').prop('readonly', false); 
            getLastserial(0);
        } else if(str == 1){
            $('#menu_serial').val('0').attr('readonly', true);
            $('#sub_menu_serial').prop('readonly', false);
        } else {
            
            $('#sub_menu_serial, #menu_serial').attr('readonly', false);
        }
        
        showMenuItesm(str);
    }

    function showMenuItesm(al){
        if(al == 0){
            $('#mainMenuItem').css('display', 'block')
            $('#subMenuItem').css('display', 'none');
            $('#subMenuItem2').css('display', 'none');
        }
        if(al == 1){
            $('#mainMenuItem').css('display', 'block')
            $('#subMenuItem').css('display', 'block');
            $('#subMenuItem2').css('display', 'block');
        }
    } 
    showMenuItesm(0);


    function getLastserial(submenu){
        var str = $('#menu_type').val(); 
        var fd = {menu: str, smenu: submenu};  
        
        $.ajax({
            url: "{{ route('dashboard.menu.last.serial') }}", 
            type: "GET", 
            data: fd,  
            dataType: 'json', 
            success: function(data) {
                console.log("getLastserial Response:", data);  
                
                if (data && data.msg) {
                    var lastserial = data.msg;  
                    
                    if (str == 0) { 
                        $('#menu_serial').val(lastserial);
                    } else {
                        $('#sub_menu_serial').val(lastserial);
                    }
                } else {
                    console.warn("Invalid response data:", data);
                }
            },
            error: function(xhr, status, error) {
                //console.error("AJAX Error:", status, error);  
                //alert("Error fetching serial number. Please try again.");
                Swal.fire({
                    title: 'Warning!',
                    text: 'New Listing Serial Number',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });	
            }
        });
    }

    
</script>  
   

<section id="sectionsection" class=""> 
    <div class="registration">
        <div class="wrapper"  >
            <div class="inner" >
            
                <form id="add_dashboard_menu" action="{{ route('dashboard.menu.store') }}" method="POST">
                    @csrf
            
                    <h3><img src="{{ asset('assets/images/b2.png') }}" style="height:25px;"alt=" ">  Create menu / sidebar </h3>
                    <p>safe your all information and account</p> 
                    
                    
                    
                    
                        <div class="form-group">
                            
                            <div class="form-wrapper m-1">
                                <label>Menu Name</label>
                                <div class="form-holder">
                                    
                                    <div class="icone">
                                        <i class="fa-solid fa-bars"></i>
                                    </div>
                                    <div class="icone2">
                                        <i class="fa-solid fa-bars"></i>
                                    </div>
                                    <input type="text" id="menu_name" name="menu_name" value=""  onChange="setMenulink(this.value)" 
                                    class="form-control" placeholder="Menu/SubMenu Name">
                                </div>
                            </div>

                            <div class="form-wrapper m-1">
                                <label>Menu Link</label>
                                <div class="form-holder">
                                    
                                    <div class="icone">
                                        <i class="fa-solid fa-link"></i>
                                    </div>
                                    <div class="icone2">
                                        <i class="fa-solid fa-link"></i>
                                    </div>
                                    <input type="text" id="menu_link" name="menu_link" value="" 
                                    class="form-control" placeholder="Auto Menu/SubMenu Link">
                                    
                                </div>
                            </div>
                                
                        </div>
                        
                        <div class="form-group">
                            <div class="form-wrapper m-1">
                                <label>Menu Icon</label>
                                <div class="form-holder">
                                    
                                    <div class="icone">
                                        <i class="fa-brands fa-square-font-awesome-stroke"></i>
                                    </div>
                                    <div class="icone2">
                                        <i class="fa-brands fa-square-font-awesome-stroke"></i>
                                    </div>
                                    <input type="text" id="menu_icon" name="menu_icon" value="" 
                                    class="form-control" placeholder="fa fa-home">
                                </div>
                            </div> 

                            
                            <div class="form-wrapper m-1">
                                <label>Menu Type</label>
                            
                                <div class="form-holder ">
                                    
                                    <div class="icone">
                                        <i class="fa-solid fa-bars"></i>
                                    </div>
                                        
                                    <select id="menu_type" name="menu_type" onChange="setMenuactivites(this.value)"  class="form-control">
                                        <option value=""  >Select Menu Type</option> 
                                        <option value="0">Menu</option>
                                        <option value="1">Sub Menu</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                        </div>


                        
                        <div class="form-group">
                            <div class="form-wrapper m-1">
                                <label>Menu Serial</label>
                                <div class="form-holder">
                                    
                                    <div class="icone">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </div>
                                    
                                    <input type="number" id="menu_serial" name="menu_serial" value="" 
                                    class="form-control" placeholder="0">
                                </div>
                            </div>

            
                            <div class="form-wrapper m-1" id="subMenuItem">
                                <label for="menu_for">Menu For</label>
                            
                                <div class="form-holder ">
                                    
                                    <div class="icone">
                                    <i class="fa-solid fa-forward"></i>
                                    </div>
                                        
                                    <select id="menu_for" name="menu_for" onchange="getLastserial(this.value)" class="form-control">
                                        <option value="0">Select Menu For</option>

                                        @foreach($menu as $rslt)
                                            <option value="{{ $rslt->id }}"> <i class="{{ $rslt->menu_icon }}"></i>  {{ $rslt->menu_name }}  </option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            
                            
                            
                        </div>


            
                        <div class="form-group">
                            <div class="form-wrapper m-1">
                                <label>Sub Menu Serial</label>
                                <div class="form-holder">
                                    
                                    <div class="icone">
                                        <i class="fa-solid fa-bars"></i>
                                    </div> 
                                    <input type="number" id="sub_menu_serial" name="sub_menu_serial"
                                    value="" class="form-control" placeholder="0">
                                </div>
                            </div>



                            


                            <div class="form-wrapper m-1 col-md-3 ">
                                <label>Status</label>
                            
                                <div class="form-holder ">
                                    
                                    <div class="icone">
                                    <i class="fa-solid fa-hand-point-right"></i>
                                    </div> 
                                    <select id="status" name="status" class="form-control">

                                        <option value="1">Active</option>
                                        <option value="0">Block</option>

                                    </select>
                                </div>
                            </div>


                        
                            <div class="form-wrapper m-1  col-md-3 ">
                                <label>View</label>
                            
                                <div class="form-holder ">
                                    
                                    <div class="icone">
                                        <i class="fa-solid fa-hand-point-right"></i>
                                    </div> 
                                    <select id="view_action" name="view_action" class="form-control">

                                        <option value="1">ON</option>
                                        <option value="0">OFF</option>

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
</section>




 





 