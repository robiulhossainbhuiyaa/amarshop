@extends('dashboard.layouts.app')

@section('content')

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





<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .toggle-switch input {
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



<div class="row element-block-example ">


    <div class="col-md-12 ">
        <div class="main-card mb-3 card bg-white">
            <div class="card-header bg-white">  
                <div class="table-header d-flex align-items-center justify-content-between  ">

                    <!-- Left Side -->
                    <div>
                        <h5 class="mb-0">{{$pageTitle}}</h5>
                    </div>
                     
                     

                </div> 
                   
            </div>


 
 

            <div class="table-responsive bg-white">
                 
                <div class="content">
                    @foreach($pagedata as $datarslt)
                    <div class="container-fluid">
                    
                        <div class="row">
                            <div class="col-md-4 mt-1 mb-1"  data-aos="fade-up" data-aos-delay="100">
                                <div class="card">
                                    <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-text-width"></i>
                                        Themes One
                                    </h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="btn-hover-shine">
                                            <img src="{{ asset('assets/images/empty-wishlist.jpg') }}" style="width:100%;"/> 
                                        </div>	
                                        <div class="custom-control custom-radio mt-2 " style="margin-bottom:-15px;" >
                                            
                                            <label for="" class="">Themes One</label>
                                            <label class="toggle-switch">
                                                <input type="radio" id="toggleSwitch" name="customRadio"
                                                {{($datarslt->dashboard == 0)? " checked": "";}} value="1" onClick="changeTheme(0,{{$datarslt->id}})" >
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-1 mb-1"  data-aos="fade-up" data-aos-delay="100">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-text-width"></i>
                                            Themes Two
                                        </h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="btn-hover-shine">
                                            <img src="{{ asset('assets/images/empty-wishlist.jpg') }}" style="width:100%;"/>
                                        </div>	
                                        <div class="custom-control custom-radio mt-2 mb-0" style="margin-bottom:-15px;">
                                                
                                                <label for="" class="">Themes Two</label>
                                                
                                            <label class="toggle-switch">
                                                <input type="radio" id="" name="customRadio"
                                                {{($datarslt->dashboard == 1)? " checked": "";}} value="2" onClick="changeTheme(1,{{$datarslt->id}})" >
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4 mt-1 mb-1"  data-aos="fade-up" data-aos-delay="100">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-text-width"></i>
                                            Themes Three
                                        </h3>
                                    </div>
                                    
                                    <div class="card-body ">
                                        <div class="btn-hover-shine">
                                            <img src="{{ asset('assets/images/empty-wishlist.jpg') }}" style="width:100%;"/>
                                        </div>
                                        <div class="custom-control custom-radio mt-2 " style="margin-bottom:-15px;">
                                            <label class="" for="toggleSwitch" >Themes Three</label> 
                                            <label class="toggle-switch">
                                                
                                                <input type="radio" id="toggleSwitch" name="customRadio"  
                                                {{($datarslt->dashboard == 2)? " checked": "";}} value="3" onClick="changeTheme(2,{{$datarslt->id}})"  >
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                            
                                            
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                    @endforeach
                        
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
 
	
		
		function changeTheme(val,id) {
			Swal.fire({
				title: 'Changing Theme...',
				text: 'Please wait...',
				allowOutsideClick: false,
				didOpen: function() {
					Swal.showLoading(); 
				}
			});

			$.ajax({
				url: "changeThemes",
				type: "POST",
				data: { val: val , id: id },
				dataType: "json",
				success: function (data) {
                    if (data.stts == "OK") {
                        Swal.fire({
                            title: "success!",
                            text: data.msg,
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
                },
				error: function(xhr) {
					Swal.close();
					console.error("AJAX Error:", xhr.responseText);  

					Swal.fire({
						title: "Error!",
						text: "Something went wrong. Please try again.",
						icon: "error",
						confirmButtonText: "OK"
					});
				}
			});
		} 
	</script>
	
 

@endsection