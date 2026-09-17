@extends('dashboard.layouts.app')

@section('content')




<!-- user_permissions -->

<div class="container-fluid mt-2">

    <!-- Page Header managewebsiteThemesattings -->

    <div class="page-header">

        <div>

            <h3><i class="{{!empty($menuIcon)? $menuIcon : $pageIcon}}"></i> 
            {{!empty($getparentMenuTitle)? $getparentMenuTitle : $pageTitle}}</h3>

            <p><i class="{{$pageIcon}}"></i> {{$pageTitle}} \  

                <a href="{{$currentPage}}"  > 
                    {{$currentPage}}
                </a>
            </p>

        </div>

    </div> 
    <!-- Statistics -->  
</div>

 

<div class="row element-block-example ">


    <div class="col-md-12 ">
        <div class="main-card mb-3 card bg-white">
            <div class="card-header bg-white">  
                <div class="table-header d-flex align-items-center justify-content-between  ">

                    <!-- Left Side -->
                    <div>
                        <h5 class="mb-0"> {{$pageTitle}} </h5>
                    </div>
                     
                    <!-- Right Side Buttons -->
                    <div class="ms-auto">

                        <div class="btn-group-sm d-flex flex-wrap justify-content-end">

                            <input
                                type="text"
                                id="ticketid"
                                onkeyup="searchTable()"
                                class="form-control search-box"
                                placeholder="Type to search..."
                            >

                        </div>

                    </div>

                </div> 
                  
                <div class="table-header d-flex align-items-center justify-content-between bg-transparent">
                    <div>
                        <h5 class="mb-0"> </h5>
                    </div>

                    <!-- Right Side Buttons -->
                    <div class="ms-auto">
                        <div class="btn-group-sm d-flex flex-wrap justify-content-end">

                            <div class="btn-group-sm  ">
                                <button class="btn-sm m-1 btn btn-outline-primary badge badge-outline-primary      btn-shadow btn-outline-2x"  onClick="ligtopen('1', 'add_user_type');"><i class=" fa fa-plus"></i> User type</button>
                                <button class="btn-sm m-1 btn btn-outline-secondary badge badge-outline-secondary  btn-shadow btn-outline-2x" onClick="rowEdit()"><i class=" fa fa-pencil-alt"></i> Edit</button> 
                                <button class="btn-sm m-1 btn btn-outline-success badge badge-outline-success      btn-shadow btn-outline-2x" onClick="makeActive(1)"><i class=" fa fa-check-circle"></i> Active</button>
                                <button class="btn-sm m-1 btn btn-outline-warning badge badge-outline-warning      btn-shadow btn-outline-2x" onClick="makeBlock(0)"><i class=" fa fa-times-circle"></i> Block</button> 
                                <button class="btn-sm m-1 btn btn-outline-danger badge badge-outline-danger        btn-shadow btn-outline-2x" onClick="makeDelete('del')"><i class=" fa fa-trash"></i> Delete</button> 
                                <a> <input type="hidden" id="checked_order_id_list" value=""/></a>
                                    
                            </div>

                            <a> <input type="hidden" id="checked_order_id_list" value=""/></a>
                            
                            

                        </div>
                    </div>

                </div>  
            </div>


 
 

            <div class="table-responsive bg-white">
                <table id="dataTable" class="align-middle mb-0 table table-striped table-hover table-bordered">
                     
                    <form control="form control" class="form-group"  id="managewebsite" method="POST">
                        @csrf
                        <thead> 
                            <tr>
                                <th> 
                                    <input type="checkbox" id="checkedall" name="checkedall" value="all" onChange="checkedAll(this.value)"/>
                                </th>
                                <th>SL.</th>
                                <th>User Type</th>
                                <th>Type Value</th>
                                <th>Status</th>
                                <th>Permission</th>
                            </tr> 
                        </thead>
                        <tbody>

                            <style>
                                .menu-row-bold {
                                    font-weight: 900;
                                }
                            </style>
                                @php
                                    $i = 0; 
                                @endphp 

                            @foreach($pagedata as $datarslt)

                                @php
                                    $i++; 
                                @endphp

                             



                                <tr class="">

                                    {{-- ID --}}
                                    <td> 
                                        <input type="checkbox" id="pro_id[]" name="pro_id[]" value="{{ $datarslt->id }}"  onClick="getOrderId()"/> 
                                    </td>
                                    {{-- ID --}}
                                    <td>
                                        {{ $i }} 
                                    </td>
 
                                    <td> 
                                        {{ $datarslt->type_name }}  
                                    </td>
 
                                    <td>
                                        {{ $datarslt->type_value }}
                                    </td> 
                                    {{-- Status --}}
                                    <td>

                                        @if($datarslt->status == 1)

                                            <span class="badge badge-success">
                                                <i class="fa fa-check-circle"></i>
                                                Active
                                            </span>

                                        @else

                                            <span class="badge badge-warning">
                                                <i class="fa fa-times-circle"></i>
                                                Block
                                            </span>

                                        @endif
 
                                    </td>
                                    <td>
                                        <div class="btn-actions-pane-right" >
                                            <div class="btn-sm m-1 btn btn-outline-info badge badge-outline-info btn-shadow btn-outline-2x" onClick="ligtopenxl('1', 'view_permission?rid={{ $datarslt->id}}')"><i class="fa-regular fa-eye"></i> view access </div>       
                                        </div>
                                    </td>
 

                                       

                                    

                                </tr>

                            @endforeach

                        </tbody>
                    </form> 
                
                </table>
            </div>
            
        </div>
    </div>
</div>



















<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 

     
		
		
    function getOrderId() {
        var checkboxValues = [];
        var cboxes = document.getElementsByName('pro_id[]');
        var len = cboxes.length;

        for (var i = 0; i < len; i++) {
            if (cboxes[i].checked) {
                checkboxValues.push(cboxes[i].value);
            }
        }

        //console.log("Selected IDs:", checkboxValues); // Check output in browser console

        if (checkboxValues.length > 0) {
            document.getElementById('checked_order_id_list').value = checkboxValues.join(",");
        } else {
            document.getElementById('checked_order_id_list').value = "";
        }
    }


    function checkedAll(val) {
        var checkboxValues = [];
        var checkall = $('#checkedall');
        var cboxes = document.getElementsByName('pro_id[]');
        var len = cboxes.length;
        if(val == "all"){
            for (var i=0; i<len; i++) {
                cboxes[i].checked = true;
                checkboxValues.push(cboxes[i].value);
            }
            checkall.val('notall');
            //showMyalert("all checked");  
        }else{
            for (var i=0; i<len; i++) {
                cboxes[i].checked = false;
            }
            checkall.val("all");
            //showMyalert("all Unchecked");
        }
        $('#checked_order_id_list').val(checkboxValues.toString());
        
    }
   
        
    function rowEdit(add){
        var checkedid = $('#checked_order_id_list').val();   
        if (checkedid && checkedid.trim() !== "") {  
                var selectedId = checkedid.split(',')[0]; 
                var encodedId = encodeURIComponent(selectedId); 
                //console.log("Selected IDs:", encodedId); // Check output in browser console
                ligtopen('1', `edit_utype?rid=${encodedId}`); 
        } else { 
            Swal.fire({
                title: 'Warning!',
                text: 'Please select at least one id to edit.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    } 
   
    function makeActive(val){
        var checkedid = $('#checked_order_id_list').val();
        if(checkedid != "")
        {
            var fd = new FormData($("#managewebsite")[0]);
            fd.append("checked_order_id_list", checkedid);
            fd.append("val", val);
            if(val == 1){
                $.ajax({
                    url: 'menu_ActiveUp',
                    data: fd,
                    type: 'post',
                    dataType:'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        
                        if(data.stts=="OK"){
                            Swal.fire({
                                title: 'Success!',
                                text: 'The status has been updated Active successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                reloadDashboardBody();
                            });
                        }else{
                            Swal.fire({
                                title: 'Error!',
                                text: data.msg,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            
                            
                        }
                        
                    }
                    
                });
                
            }
        }else{
            Swal.fire({
                title: 'Warning!',
                text: 'Please mark at least one row!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    }
 
    function makeBlock(val) {
        var checkedid = $('#checked_order_id_list').val();
        
        if (checkedid != "") {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to block the selected users?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Block them!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var fd = new FormData($("#managewebsite")[0]);
                    fd.append("checked_order_id_list", checkedid);
                    fd.append("val", val);

                    if(val == 0){
                        $.ajax({
                            url: 'menu_ActiveUp',
                            data: fd,
                            type: 'post',
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                if (data.stts == "OK") {
                                    Swal.fire(
                                        "Blocked!",
                                        "The selected users have been blocked.",
                                        "success"
                                    ).then(() => {
                                        reloadDashboardBody();
                                    });
                                } else {
                                    Swal.fire("Error!", data.msg, "error");
                                }
                            }
                        });
                    }
                }
            });
        } else {
            Swal.fire("Oops!", "Please mark at least one row!", "warning");
        }
    }
    
    function makeDelete(val) {
        var checkedid = $('#checked_order_id_list').val();

        if (checkedid !== "") {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteSelectedItems(checkedid, val);
                }
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "No selection",
                text: "Please select an item to delete!"
            });
        }
    }

    function deleteSelectedItems(checkedid, val) {
        var fd = new FormData($("#managewebsite")[0]);
        fd.append("removeids", checkedid);
        fd.append("action", val);

        $.ajax({
            url: 'deleteup',
            data: fd,
            type: 'post',
            dataType: 'json',
            processData: false, 
            contentType: false,
            success: function (data) {
                if (data.stts == "OK") {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Items have been deleted.",
                        icon: "success"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.msg
                    });
                }
            }
        });
    }
    
   

    function processingData(id,act){
        if(act == 1){
        $('#loadImage'+id).css('display', 'block');
        }
        else{
        $('#loadImage'+id).css('display', 'none');
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



    
    
 
    function searchTable() {

        const input = document.getElementById("ticketid");
        const table = document.getElementById("dataTable");
    
        const filter = input.value.toUpperCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function(row) {

            const rowText = row.textContent.toUpperCase();

            if (rowText.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }

        });
    }
</script>

@endsection