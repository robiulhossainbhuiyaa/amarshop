@extends('front.layouts.app')

@section('contant')

    <div class="m-5" id="top"> 
    </div>
    
    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="{{ asset('assets/css/wishlist.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

    $(document).ready(function(){

        $(".removeWishlist").click(function(){

            let id=$(this).data("id");

            let card=$(this).closest(".col-lg-3");

            Swal.fire({

                title:"Remove Product?",

                text:"This product will be removed from wishlist.",

                icon:"warning",

                showCancelButton:true,

                confirmButtonColor:"#dc3545",

                confirmButtonText:"Yes Remove"

            }).then((result)=>{

                if(result.isConfirmed){

                    $.ajax({

                        url:"/wishlist/"+id,

                        type:"DELETE",

                        data:{
                            _token:"{{ csrf_token() }}"
                        },

                        success:function(res){

                            if(res.status){

                                card.fadeOut(500,function(){

                                    $(this).remove();

                                });

                                Swal.fire({

                                    icon:"success",

                                    title:"Removed",

                                    text:res.message,

                                    timer:1500,

                                    showConfirmButton:false

                                });

                            }

                        }

                    });

                }

            });

        });

    });

</script>

    <!-- Banner -->

    <section class="wishlist-banner">

        <div class="container">

            <h2>
                <i class="fa-solid fa-heart text-danger"></i>
                My Wishlist
            </h2>

            <p>

                Home
                <span>/</span>
                Wishlist

            </p>

        </div>

    </section>



    <!-- Wishlist -->

    <section class="wishlist-area">

        <div class="container">

            <div class="row gy-4">

                <!-- Product -->

                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="wishlist-card">

                        <span class="discount">

                            -25%

                        </span>

                        <button class="remove-btn removeWishlist" data-id="1">

                            <i class="fa fa-xmark"></i>

                        </button>

                        <div class="image">

                            <img src="{{ asset('assets/images/men-01.jpg') }}"
                                class="img-fluid">

                        </div>

                        <div class="content">

                            <div class="rating">

                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa-regular fa-star"></i>

                            </div>

                            <h5>

                                Nike Air Max Shoes

                            </h5>

                            <div class="price">

                                <span class="new-price">

                                    $120

                                </span>

                                <span class="old-price">

                                    $160

                                </span>

                            </div>

                            <span class="stock">

                                In Stock

                            </span>

                            <button class="cart-btn">

                                <i class="fa fa-cart-shopping"></i>

                                Add To Cart

                            </button>

                        </div>

                    </div>

                </div>



                <!-- Product -->

                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="wishlist-card">

                        <span class="discount bg-success">

                            NEW

                        </span>

                        <button class="remove-btn removeWishlist">

                            <i class="fa fa-xmark"></i>

                        </button>

                        <div class="image">

                            <img src="{{ asset('assets/images/men-02.jpg') }}"
                                class="img-fluid">

                        </div>

                        <div class="content">

                            <div class="rating">

                                ★★★★★

                            </div>

                            <h5>

                                Leather Backpack

                            </h5>

                            <div class="price">

                                <span class="new-price">

                                    $89

                                </span>

                            </div>

                            <span class="stock">

                                In Stock

                            </span>

                            <button class="cart-btn">

                                <i class="fa fa-cart-shopping"></i>

                                Add To Cart

                            </button>

                        </div>

                    </div>

                </div>



                <!-- Product -->

                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="wishlist-card">

                        <button class="remove-btn  removeWishlist">

                            <i class="fa fa-xmark"></i>

                        </button>

                        <div class="image">

                            <img src="{{ asset('assets/images/women-02.jpg') }}"
                                class="img-fluid">

                        </div>

                        <div class="content">

                            <div class="rating">

                                ★★★★☆

                            </div>

                            <h5>

                                Smart Watch

                            </h5>

                            <div class="price">

                                <span class="new-price">

                                    $230

                                </span>

                                <span class="old-price">

                                    $300

                                </span>

                            </div>

                            <span class="stock out-stock">

                                Out Of Stock

                            </span>

                            <button class="cart-btn disabled">

                                Out Of Stock

                            </button>

                        </div>

                    </div>

                </div>



                <!-- Product -->

                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="wishlist-card">

                        <span class="discount">

                            SALE

                        </span>

                        <button class="remove-btn  removeWishlist">

                            <i class="fa fa-xmark"></i>

                        </button>

                        <div class="image">

                            <img src="{{ asset('assets/images/women-03.jpg') }}"
                                class="img-fluid">

                        </div>

                        <div class="content">

                            <div class="rating">

                                ★★★★★

                            </div>

                            <h5>

                                Gaming Headphone

                            </h5>

                            <div class="price">

                                <span class="new-price">

                                    $65

                                </span>

                                <span class="old-price">

                                    $90

                                </span>

                            </div>

                            <span class="stock">

                                In Stock

                            </span>

                            <button class="cart-btn">

                                <i class="fa fa-cart-shopping"></i>

                                Add To Cart

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <?php $wishlists = 0;
if($wishlists > 0)
{ ?>

    <div class="row gy-4">
 

            <div class="col-lg-3 col-md-4 col-sm-6">

                <!-- Wishlist Card এখানে থাকবে -->

            </div>
 
    </div>

    <?php 

}else
{ ?>

    <div class="empty-wishlist">

        <img src="{{ asset('./assets/images/empty-wishlist.jpg') }}" alt="Wishlist">

        <h3>Your Wishlist is Empty</h3>

        <p>
            Looks like you haven't added anything to your wishlist yet.
        </p>

        <a href="{{ url('/products') }}" class="shop-btn">

            <i class="fa-solid fa-bag-shopping"></i>

            Continue Shopping

        </a>

    </div>

    <?php  
}  ?>



 

 

@endsection