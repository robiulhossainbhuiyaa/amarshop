<!-- view_permission_user -->
<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">  
<!-- STYLE CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/addEditPage.css') }}">
 


<script type="text/javascript">  

    function getOrderId() {

        var checkboxValues = [];

        var cboxes = document.getElementsByName('pro_id[]');

        for (var i = 0; i < cboxes.length; i++) {
            if (cboxes[i].checked) {
                checkboxValues.push(cboxes[i].value);
            }
        }

        var cid = checkboxValues.join(',');

        document.getElementById('checkedorderidlist').value = cid;

        //console.log("Selected IDs:", cid);
    }


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

 




</script>


 
                        
    <style>
        .toggle_switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .toggle_switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #a84040;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "OFF";
            height: 23px;
            width: 23px;
            left: 3px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 20px;
            text-align: center;
            line-height: 24px;
            font-size: 9px;
            font-weight: bold;
            color: red;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }

        input:checked + .slider:before {
            transform: translateX(30px);
            content: "ON";
            color: green;
        }
    </style>

    @php
        use App\Models\Usertypes;
        use App\Models\DashboardMenu;
        use App\Models\Userpermission;

        $modelmenu = new DashboardMenu();
        $modelutype = new Usertypes();
        $modeluper = new Userpermission();

        $permission = $modeluper->getPermissionCmd($rid);
        $perdata = $permission->permission_cmd ?? '';
        
		$getTypename = $modelutype->getUtypeName($rid)->type_name;

        $permission_data = array_filter(
            array_map('trim', explode(',', $perdata))
        );

        $i = 0;
    @endphp

<section id="sectionsection" class=""> 
    <div class="registration">
        <div class="wrapper"  >
            <div class="inner" >
                
                <form id="add_dashboard_menu" action="{{ route('dashboard.add_user_permision') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf

                    
                    <h3><img src="{{ asset('assets/images/b2.png') }}" style="height:25px;"alt=" ">
                        What will <b class="text-primary" >{{$getTypename}}</b> be allowed to use?
                    </h3>
                    <p>safe your all information and account</p>  
                     
                    
                    <input
                        type="hidden"
                        id="checkedorderidlist"
                        name="checked_order_id_list"
                        value=""
                        readonly
                        style="width:100%;"
                    >
                    <input type="hidden" id="permission_name" name="permission_name" value="{{$getTypename}}"/>
                    <input type="hidden" id="permission_for_user_type" name="permission_for_user_type" value="{{$rid}}"/>
            

                    <div class="row">

                        @foreach($pagedata as $datarslt)

                            @php
                                $i++;

                                // Check main menu
                                $checked = in_array($datarslt->id, $permission_data)
                                    ? 'checked'
                                    : '';

                                // Get submenu
                                $submenus = $modelmenu->getSubmenu($datarslt->id);

                                $hasSubmenu = $submenus && count($submenus) > 0;
                            @endphp


                            {{-- MAIN MENU --}}
                            <div class="col-md-6 mb-2">

                                <div class="form-wrapper m-1">

                                    <label class="badge badge-primary" >
                                        ID: {{ $i }}
                                        {{ $datarslt->menu_name }}
                                    </label>

                                    <div class="form-holder">
 
                                        <label  for="toggleSwitch{{ $datarslt->id }}" class="toggle_switch ml-5">

                                            <input
                                                type="checkbox" id="toggleSwitch{{ $datarslt->id }}" 
                                                {{ $checked }}
                                                name="pro_id[]" 
                                                value="{{ $datarslt->id }}"
                                                onclick="getOrderId()"
                                            >

                                            <span class="slider"></span>

                                        </label>

                                    </div>

                                </div>

                                 


                                {{-- SUB MENU --}}
                                @php
                                    $sub =  0;
                                @endphp
                                @if($hasSubmenu)

                                    <div class="form-group col-md-12">

                                        @foreach($submenus as $subIndex => $rstlsubmenu)
                                            

                                            @php
                                                $subSerial = $i . '.' . ($subIndex + 1);
                                                $sub++;

                                                $checkedsub = in_array(
                                                    $rstlsubmenu->id,
                                                    $permission_data
                                                )
                                                    ? 'checked'
                                                    : '';
                                            @endphp


                                            <div class="form-wrapper m-1">

                                                <label>
                                                    ID:{{ $subSerial }}  
                                                    {{ $rstlsubmenu->menu_name }}
                                                </label>

                                                <div class="form-holder">

                                                    <label for="toggleSwitch{{ $rstlsubmenu->id }}"  class="toggle_switch ml-5">

                                                        <input
                                                            type="checkbox"
                                                            id="toggleSwitch{{ $rstlsubmenu->id }}" 
                                                            {{ $checkedsub }}
                                                            name="pro_id[]"
                                                            value="{{ $rstlsubmenu->id }}"
                                                            onclick="getOrderId()"
                                                        >

                                                        <span class="slider"></span>

                                                    </label>

                                                </div>

                                            </div>
                                            @if($sub % 2 == 0)
                                            </div>
                                            <div class="form-group col-md-12 ">

                                            @endif
                                            

                                        @endforeach
                                    </div>

                                @endif

                            </div>

                        @endforeach

                        			
                            
                        
                    
                        
                    
                    
                    
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

                    </div> 				
							 
                </form>
                

            </div> 
        </div> 
    </div> 
</section>
