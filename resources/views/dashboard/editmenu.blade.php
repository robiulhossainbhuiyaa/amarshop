 
<link rel="stylesheet" href="assets/css/add_dashboard_menu.css">
 
<!-- <div class="menu-page">-->


@foreach($datarslt as $rsltmenu)

    <div class="menu-card"> 

        <!-- Logo -->
        <div class="logo-area">
            <img src="assets/images/b.png" alt="AmarShop">
            <h3>Edit Dashboard Menu</h3>
            <p>Edit sidebar menu</p>
        </div>

        <form id="add_dashboard_menu" action="{{ route('dashboard.menu.editMenu') }}" method="POST">

            <input type="hidden" name="rid" id="rid" value="{{ $rsltmenu->id }}" />
            @csrf

            <div class="row">

                 

                <!-- Menu Name -->
                <div class="col-md-6 mb-4">
                    <label>Menu Name</label>
                    <input type="text" id="menu_name" name="menu_name" value="{{ $rsltmenu->menu_name }}"  onChange="setMenulink(this.value)" 
                    class="form-control" placeholder="Menu/SubMenu Name">
                </div>

                <!-- Menu Link -->
                <div class="col-md-6 mb-4">
                    <label>Menu Link</label>
                    <input type="text" id="menu_link" name="menu_link" value="{{ $rsltmenu->menu_link }}" class="form-control" placeholder="Auto Menu/SubMenu Link">
                </div>

                <!-- Menu Icon -->
                <div class="col-md-6 mb-4">
                    <label>Menu Icon</label>
                    <div class="icon-input">
                        <i class="fa fa-home preview-icon"></i>
                        <input type="text" id="menu_icon" name="menu_icon" value="{{ $rsltmenu->menu_icon }}" class="form-control" placeholder="fa fa-home">
                    </div>
                </div>

                <!-- Menu Type -->
                <div class="col-md-6 mb-4">
                    <label>Menu Type</label>
                    <select id="menu_type" name="menu_type" onChange="setMenuactivites(this.value)"  class="form-control">
                        <option value="">Select Menu Type</option>

                        <option value="0" @selected($rsltmenu->menu_type == 0)>
                            Menu
                        </option>

                        <option value="1" @selected($rsltmenu->menu_type == 1)>
                            Sub Menu
                        </option>
                    </select>
                </div>

                

                <!-- Menu Serial -->
                <div class="col-md-6 mb-4">
                    <label>Menu Serial</label>
                    <input type="number" readonly id="menu_serial" name="menu_serial" value="{{ $rsltmenu->menu_serial }}" class="form-control" placeholder="0">
                </div>

                <!-- Menu For -->
                
                <div class="col-md-6 mb-4" id="subMenuItem">

                    <label for="menu_for">Menu For</label>

                    <select id="menu_for" name="menu_for" onchange="getLastserial(this.value)" class="form-control">
                        <option value="0">Select Menu For</option>

                        @foreach($menu as $rslt) 
                            <option value="{{ $rslt->id }}" @selected($rsltmenu->menu_for == $rslt->id )>
                                {{ $rslt->menu_name }} 
                            </option>
                        @endforeach

                    </select>

                </div>

                <!-- Sub Menu Serial -->
                <div class="col-md-6 mb-4" id="subMenuItem2">
                    <label>Sub Menu Serial</label>
                    <input type="number" id="sub_menu_serial" name="sub_menu_serial" value="{{ $rsltmenu->sub_menu_serial }}" class="form-control" placeholder="01">
                </div>

                <!-- Status -->
                <div class="col-md-3 mb-4">
                    <label>Status</label>
                    <select id="status" name="status" class="form-control">

                        <option value="1" @selected($rsltmenu->status == 1)>Active</option>
                        <option value="0" @selected($rsltmenu->status == 0)>Block</option>

                    </select>
                </div>

                <!-- View -->
                <div class="col-md-3 mb-4">
                    <label>View</label>
                    <select id="view_action" name="view_action" class="form-control">

                        <option value="1" @selected($rsltmenu->view_action == 1)>ON</option>
                        <option value="0" @selected($rsltmenu->view_action == 0)>OFF</option>

                    </select>
                </div>

            </div>

            <div class="button-area">
                <button type="reset" class="btn btn-light">
                    <i class="fa fa-rotate-left"></i> Reset
                </button>
 
                <button type="submit" id="submitbutton" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save Menu
                </button>
                <img src="{{ asset('assets/images/loading.gif') }}" style="display:none;" class="float-right" id="loadImage"/>
            </div>
            <div class="form-group">
                <div class="alert alert-danger" id="alert_view" style="margin-top:10px;display:none;"></div>
                <div class="alert alert-success" id="success_view" style="margin-top:10px;display:none;"></div>
            </div>  

        </form>

    </div>
@endforeach    
<!-- 

</div> -->




 
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
            // $('#subMenuItem').css('display', 'none');
            // $('#subMenuItem2').css('display', 'none');
        }
        if(al == 1){
            $('#mainMenuItem').css('display', 'block')
            // $('#subMenuItem').css('display', 'block');
            // $('#subMenuItem2').css('display', 'block');
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
                //console.error("AJAX Error:", status, error); // যদি AJAX fail হয়
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
 