@extends('dashboard.layouts.app')

@section('content')

<div class="container-fluid mt-2">

    <!-- Page Header dashboard_manage -->

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

      

    <div class="row mt-4">

        <!-- Recent Orders -->

        <div class="col-lg-12 mb-4">

            <div class="table-card">

                
                <div class="table-header d-flex align-items-center justify-content-between">

                    <!-- Left Side -->
                    <div>
                        <h5 class="mb-0">{{$pageTitle}}</h5>
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
                
                <div class="table-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0"> </h5>
                    </div>
 
                    <!-- Right Side Buttons -->
                    <div class="ms-auto">
                        <div class="btn-group-sm d-flex flex-wrap justify-content-end">
 
                            <a href="javascript:void(0)"
                            class="btn btn-primary text-left btn-shadow m-1"
                            onclick="ligtopen('1', 'addDashboardMenu')">
                                <i class="fa fa-plus"></i> Add
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-dark text-left btn-shadow m-1"
                            onClick="rowEdit()">
                                <i class="fa fa-pencil-alt"></i> Edit
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-primary text-left btn-shadow m-1"
                            onClick="makeView(1)">
                                <i class="fas fa-eye"></i> View On
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-warning text-left btn-shadow m-1"
                            onClick="makeView(0)">
                                <i class="fas fa-eye-slash"></i> View Off
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-success text-left btn-shadow m-1"
                            onClick="makeActive(1)">
                                <i class="fa fa-check-circle"></i> Active
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-warning text-left btn-shadow m-1"
                            onClick="makeBlock(0)">
                                <i class="fa fa-times-circle"></i> Block
                            </a>

                            <a href="javascript:void(0)"
                            class="btn btn-danger text-left btn-shadow m-1"
                            onClick="makeDelete('del')">
                                <i class="fa fa-trash"></i>
                            </a>
 
                            <a> <input type="hidden" id="checked_order_id_list" value=""/></a>
                            
                             

                        </div>
                    </div>

                </div> 

                <div class="table-responsive">

                    <table  id="dataTable" class="table align-middle">
                        <form id="managewebsite" method="POST">
                        @csrf

                        <thead>

                            <tr>
                                
                                <th>
                                    SL.
                                    </br>
                                    <input type="checkbox" id="checkedall" name="checkedall" value="all" onChange="checkedAll(this.value)"/>
                                </th>
                                <th>Menu Name </br> Menu Icon </th>
                                <th>Menu Link</th> 
                                <th>Menu For</th> 
                                <th>Menu Serial</th> 
                                <th>Sub Menu Serial</th> 
                                <th>Status </br> View</th>

    

                                

                            </tr>

                        </thead>

                        <tbody>

                            <style>
                                .menu-row-bold {
                                    font-weight: 900;
                                }
                            </style>
                           <?php $i = 0; ?>
                            @foreach($menuData as $rsltData)
                                <?php $i++; ?>

                                <tr class="{{ $rsltData->menu_for == 0 ? 'status shipping  menu-row-bold' : '' }}">

                                    {{-- ID --}}
                                    <td>
                                        {{ $i }} </br>
                                        <input type="checkbox" id="pro_id[]" 
                                        name="pro_id[]" value="{{ $rsltData->id }}" 
                                        onClick="getOrderId()"/> 
                                    </td>

                                    {{-- Menu Name --}}
                                    <td> 
                                        <b>{{ $rsltData->menu_name }} </b>
                                        
                                        </br>
                                        <i class="{{ $rsltData->menu_icon }}"></i>
                                        {{ $rsltData->menu_icon }}
                                    </td>

                                    {{-- Menu Link --}}
                                    <td>
                                        {{ $rsltData->menu_link }}
                                    </td>

                                     

                                    {{-- Menu For --}}
                                    <td>
                                        {{ $rsltData->menu_for }}
                                    </td>

                                    {{-- Menu Serial --}}
                                    <td>
                                        {{ $rsltData->menu_serial }}
                                    </td>

                                    {{-- Sub Menu Serial --}}
                                    <td>

                                        @if($rsltData->menu_for == 0)

                                            {{ $rsltData->sub_menu_serial }}

                                        @else

                                            <input
                                                type="text"
                                                value="{{ $rsltData->sub_menu_serial }}"
                                                onchange="upmenuSerial('{{ $rsltData->id }}', this.value)"
                                                style="width:50px;"
                                            >

                                            <img
                                                src="{{ asset('assets/images/loading.gif') }}"
                                                alt="img"
                                                style="display:none;  "
                                                class="float-right"
                                                id="loadImage{{ $rsltData->id }}"
                                            >

                                        @endif

                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        @if($rsltData->status == 1)

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

                                        </br>

                                        @if($rsltData->view_action == 1)

                                            <span class="badge badge-primary">
                                                <i class="fas fa-eye"></i>
                                                View ON
                                            </span>

                                        @else

                                            <span class="badge badge-danger">
                                                <i class="fas fa-eye-slash"></i>
                                                View OFF
                                            </span>

                                        @endif

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

    



</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script >

     
		
		
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
        //console.log("Selected IDs:", checkedid); // Check output in browser console

        if (checkedid && checkedid.trim() !== "") {  
                var selectedId = checkedid.split(',')[0]; 
                var encodedId = encodeURIComponent(selectedId); 
                //console.log("Selected IDs:", encodedId); // Check output in browser console
                ligtopen('1', `edit_menu?rid=${encodedId}`); 
        } else { 
            Swal.fire({
                title: 'Warning!',
                text: 'Please select at least one id to edit.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    } 
    function makeView(val) {
        var checkedid = $('#checked_order_id_list').val();

        if (checkedid == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Please mark at least one row!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        var fd = new FormData($("#managewebsite")[0]);
        fd.append("checked_order_id_list", checkedid);
        fd.append("val", val);

        if (val >= 0) {
            $.ajax({
                url: 'menuView',
                data: fd,
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(data) {
                    if (data.stts == "OK") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Menu updated successfully!',
                            confirmButtonColor: '#28a745',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.msg,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
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
                    url: 'menu_Active',
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
                                location.reload();
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
                            url: 'menu_Active',
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
                                        location.reload();
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
            url: 'menuDelete',
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
    
    function upmenuSerial(id, val) {
        if (val <= 0 || id <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Data!',
                text: 'Please provide valid ID and Value.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        processingData(id,1);

        var fd = new FormData($("#managewebsite")[0]);
        fd.append("upid", id);
        fd.append("upval", val);

        /*
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

         */

        $.ajax({
            url: 'menuserialUpdate',
            data: fd,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                //Swal.close();
                processingData(id,0);

                if (data.stts == "OK") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Menu serial updated successfully!',
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();  
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.msg,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Try Again'
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
    
    
</script>

<script>
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