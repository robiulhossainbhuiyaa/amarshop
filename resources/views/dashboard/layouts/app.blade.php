<!DOCTYPE html>
<html lang="en"> 
<head> 
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <meta name="description" content="">
    <meta name="author" content=""> 
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
 
    <title>Bhuiya Shop Ecommerce Website {{$getparentMenuTitle ?? ''}} {{$pageTitle ?? ''}} {{$currentPage ?? ''}}</title>
 
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/b2.png') }}"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-hexashop.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/header_ex.css') }}"> 
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> 
    @stack('styles')

</head> 

    <body> 
            <!-- =========================================================
                HEADER
            ========================================================== --> 
        
                @include('dashboard.partials.header') 
                @include('dashboard.partials.sidebar')

                <!-- =========================================================
                MAIN CONTENT
                ========================================================== -->

                

                    <main class="dashboard-content">
                        
                        <div class="dashboard-wrapper" id="dashboardBodyLoad">
                            @yield('content')
                        </div>

                    </main>

                
 
                <!-- =========================================================
                COMMON NORMAL MODAL
                ========================================================== -->

                <div class="modal fade"
                    id="myPage"
                    tabindex="-1"
                    role="dialog"
                    aria-hidden="true">

                    <div class="modal-dialog modal-lg"
                        role="document">

                        <div class="modal-content">


                            <!-- MODAL HEADER -->

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <img src="{{ asset('assets/images/b.png') }}" style="height:20px;"alt="img">
                                </h5>

                                <button type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close">

                                    <span aria-hidden="true">
                                        &times;
                                    </span>

                                </button>

                            </div>


                            <!-- MODAL BODY -->

                            <div class="modal-body"
                                id="myPageBody">

                                <div class="text-center p-4">

                                    <i class="fas fa-spinner fa-spin fa-2x"></i>

                                    <p class="mt-2">
                                        Loading...
                                    </p>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>


                <!-- =========================================================
                    LARGE MODAL 
                ========================================================== -->

                <div class="modal fade"
                    id="myPagexl"
                    tabindex="-1"
                    role="dialog"
                    aria-hidden="true">

                    <div class="modal-dialog modal-xl"
                        role="document">

                        <div class="modal-content">


                            <!-- HEADER -->

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <img src="{{ asset('assets/images/b.png') }}" style="height:20px;"alt="img">
                                </h5>

                                <button type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close">

                                    <span aria-hidden="true">
                                        &times;
                                    </span>

                                </button>

                            </div>


                            <!-- BODY -->

                            <div class="modal-body"
                                id="myPageBodyxl">

                                <div class="text-center p-4">

                                    <i class="fas fa-spinner fa-spin fa-2x"></i>

                                    <p class="mt-2">
                                        Loading...
                                    </p>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

                
                <!-- =========================================================
                    FOOTER
                ========================================================== -->
        
                @include('dashboard.partials.footer') 


            <!-- =========================================================
                JQUERY
                ONLY ONE JQUERY
            ========================================================== -->

            <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>


            <!-- =========================================================
                POPPER
            ========================================================== -->

            <script src="{{ asset('assets/js/popper.js') }}"></script>


            <!-- =========================================================
                BOOTSTRAP JS
                ONLY ONE BOOTSTRAP JS
            ========================================================== -->

            <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>


            <!-- =========================================================
                TEMPLATE PLUGINS
            ========================================================== -->

            <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>

            <script src="{{ asset('assets/js/accordions.js') }}"></script>

            <script src="{{ asset('assets/js/datepicker.js') }}"></script>

            <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>

            <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>

            <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>

            <script src="{{ asset('assets/js/imgfix.min.js') }}"></script>

            <script src="{{ asset('assets/js/slick.js') }}"></script>

            <script src="{{ asset('assets/js/lightbox.js') }}"></script>

            <script src="{{ asset('assets/js/isotope.js') }}"></script>


            <!-- =========================================================
                CUSTOM JS
            ========================================================== -->

            <script src="{{ asset('assets/js/custom.js') }}"></script>
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]').attr('content')
                    }
                });




                $(document).on('show.bs.modal', '.modal', function () {

                    $('body').css('padding-right', '0');

                });

                $(document).on('hidden.bs.modal', '.modal', function () {

                    $('body').css('padding-right', '');

                });
            </script>
            
            <script src="{{ asset('assets/js/dashboard.js') }}"></script>

            <!-- =========================================================
                SWEETALERT2 JS
                AFTER JQUERY + BOOTSTRAP
            ========================================================== -->

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Bootstrap -->  
            
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>  

            <!-- =========================================================
                MODAL FUNCTIONS
            ========================================================== -->

            <script>

                /*
                ==========================================================
                NORMAL MODAL
                ==========================================================
                */

                function ligtopen(id, link) {

                    $('#myPage').modal('show');


                    $('#myPageBody').html(`

                        <div class="text-center p-4">

                            <div class="alert alert-info">

                                <i class="fas fa-sync fa-spin"></i>

                                Loading...

                            </div>

                        </div>

                    `);


                    $('#myPageBody').load(link, function(response, status, xhr) {

                        if (status === "error") {

                            $('#myPageBody').html(`

                                <div class="alert alert-danger">

                                    <i class="fas fa-exclamation-triangle"></i>

                                    Loading failed.

                                </div>

                            `);

                        }

                    });

                }


                /*
                ==========================================================
                LARGE MODAL
                ==========================================================
                */

                function ligtopenxl(id, link) {

                    $('#myPagexl').modal('show');


                    $('#myPageBodyxl').html(`

                        <div class="text-center p-4">

                            <div class="alert alert-info">

                                <i class="fas fa-sync fa-spin"></i>

                                Loading...

                            </div>

                        </div>

                    `);


                    $('#myPageBodyxl').load(link, function(response, status, xhr) {

                        if (status === "error") {

                            $('#myPageBodyxl').html(`

                                <div class="alert alert-danger">

                                    <i class="fas fa-exclamation-triangle"></i>

                                    Loading failed.

                                </div>

                            `);

                        }

                    });

                }


                /*
                ==========================================================
                CLOSE NORMAL MODAL
                ==========================================================
                */

                function ligtclose(id) {

                    $('#myPage').modal('hide');

                }


                /*
                ==========================================================
                CLOSE LARGE MODAL
                ==========================================================
                */

                function ligtclosexl(id) {

                    $('#myPagexl').modal('hide');

                }

            </script>

 

            <!-- =========================================================
                PORTFOLIO / FILTER SCRIPT
            ========================================================== -->

            <script>

                $(function() {

                    var selectedClass = "";

                    $("p").click(function() {

                        selectedClass = $(this).attr("data-rel");

                        $("#portfolio").fadeTo(50, 0.1);

                        $("#portfolio div")
                            .not("." + selectedClass)
                            .fadeOut();


                        setTimeout(function() {

                            $("." + selectedClass).fadeIn();

                            $("#portfolio").fadeTo(50, 1);

                        }, 500);

                    });

                });

            </script>


            <!-- =========================================================
                PAGE SPECIFIC JS
            ========================================================== -->

            @stack('scripts')



            

            

            
    </body>

</html>