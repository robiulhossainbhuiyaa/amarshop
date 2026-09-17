@extends('front.layouts.app')

@section('contant')
 
    <div class="m-5" id="top"> 
    </div>

    <!-- Custom CSS --> 
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    

     
    <!-- Banner -->
 
<script>

$(function(){

    $(".qty-plus,.qty-minus").click(function(){

        let btn=$(this);

        let cart=btn.data("id");

        let type=btn.hasClass("qty-plus")?"plus":"minus";

        $.ajax({

            url:"",

            type:"POST",

            data:{

                cart_id:cart,

                type:type,

                _token:"{{ csrf_token() }}"

            },

            success:function(res){

                if(res.status){

                    btn.parent()

                       .find(".qty-input")

                       .val(res.qty);

                    btn.closest("tr")

                       .find(".product-total")

                       .html("$"+res.total);

                    // Step 4-এ এখানে Subtotal ও Grand Total-ও আপডেট করব

                }

            }

        });

    });

});

</script>
 
<section class="cart-banner">

<div class="container">

<h2>

<i class="fa-solid fa-cart-shopping"></i>

Shopping Cart

</h2>

<p>

Home /

Your Cart

</p>

</div>

</section>

<!-- Cart -->

<section class="cart-area">

<div class="container">

<div class="row">

<!-- Cart Products -->

<div class="col-lg-8">

<div class="cart-table table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>Product</th>

<th>Price</th>

<th>Quantity</th>

<th>Total</th>

<th></th>

</tr>

</thead>

<tbody>

<tr>

<td>

<div class="cart-product">

<img src="{{ asset('assets/images/instagram-02.jpg') }}">

<div>

<h5>Nike Air Max Shoes</h5>

<p>Brand : Nike</p>

<p>SKU : NK001</p>

</div>

</div>

</td>

<td>

$120

</td>

<td>

 





<div class="qty-box">

    <button
    class="qty-minus"
    data-id="1">

        -

    </button>

    <input
    type="text"
    class="qty-input"
    value="1"
    readonly>

    <button
    class="qty-plus"
    data-id="1">

        +

    </button>

</div>







</td>

<td>

$120

</td>

<td>

<button class="remove-btn">

<i class="fa fa-trash"></i>

</button>

</td>

</tr>

<tr>

<td>

<div class="cart-product">

<img src="{{ asset('assets/images/instagram-01.jpg') }}">

<div>

<h5>Leather Backpack</h5>

<p>Brand : Wildcraft</p>

<p>SKU : BG101</p>

</div>

</div>

</td>

<td>

$89

</td>

<td>

 





<div class="qty-box">

    <button
    class="qty-minus"
    data-id="2">

        -

    </button>

    <input
    type="text"
    class="qty-input"
    value="2"
    readonly>

    <button
    class="qty-plus"
    data-id="2">

        +

    </button>

</div>







</td>

<td>

$178

</td>

<td>

<button class="remove-btn">

<i class="fa fa-trash"></i>

</button>

</td>

</tr>

</tbody>

</table>

</div>

<!-- Coupon -->

<div class="coupon-box">

<input type="text"

placeholder="Enter Coupon Code">

<button>

Apply Coupon

</button>

</div>

</div>

<!-- Summary -->

<div class="col-lg-4">

<div class="cart-summary">

<h4>

Order Summary

</h4>

<hr>

<div class="summary-row">

    <span>Subtotal</span>

    <strong id="subtotal">

        <?php //${{ $subtotal }} ?>

    </strong>
    <strong id="grandTotal">

        <?php  //${{ $grandTotal }} ?>

    </strong>
</div>

<div class="summary-row">

<span>Shipping</span>

<strong>$20</strong>

</div>

<div class="summary-row">

<span>Tax</span>

<strong>$12</strong>

</div>

<hr>

<div class="summary-row total">

<span>Total</span>

<strong>$330</strong>

</div>

<a href="#"

class="checkout-btn">

Proceed To Checkout

</a>

<a href="/products"

class="continue-btn">

Continue Shopping

</a>

</div>

</div>

</div>

</div>

</section> 
 


 

@endsection