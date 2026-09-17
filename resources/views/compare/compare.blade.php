@extends('front.layouts.app')

@section('contant')
 
    <div class="m-5" id="top"> 
    </div>

    <!-- Custom CSS --> 
    <link rel="stylesheet" href="{{ asset('assets/css/compare.css') }}">  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

     
    <!-- Banner -->
 
    <section class="compare-banner">

        <div class="container">

            <h2>
                <i class="fa-solid fa-code-compare text-danger"></i>
                Compare Products
            </h2>

            <p>

                Home
                <span>/</span>
                Compare

            </p>

        </div>

    </section>

<!-- Compare Table -->

<section class="compare-area">

<div class="container">

<div class="table-responsive">

<table class="table compare-table align-middle">

<thead>

<tr>

<th width="220">

    Product

    </th>

        <th>

            <img src="{{ asset('assets/images/instagram-01.jpg') }}"
            class="product-image">

            <h5>Nike Air Max</h5>

        </th>

    <th>

<img src="{{ asset('assets/images/instagram-02.jpg') }}"
class="product-image">

<h5>Leather Backpack</h5>

</th>

<th>

<img src="{{ asset('assets/images/instagram-03.jpg') }}"
class="product-image">

<h5>Smart Watch</h5>

</th>

</tr>

</thead>

<tbody>

<tr>

<td>Price</td>

<td>$120</td>

<td>$89</td>

<td>$230</td>

</tr>

<tr>

<td>Old Price</td>

<td>$160</td>

<td>-</td>

<td>$300</td>

</tr>

<tr>

<td>Brand</td>

<td>Nike</td>

<td>Wildcraft</td>

<td>Apple</td>

</tr>

<tr>

<td>Category</td>

<td>Men Shoes</td>

<td>Bag</td>

<td>Watch</td>

</tr>

<tr>

<td>Rating</td>

<td>★★★★★</td>

<td>★★★★☆</td>

<td>★★★★★</td>

</tr>

<tr>

<td>Stock</td>

<td>

<span class="badge bg-success">

In Stock

</span>

</td>

<td>

<span class="badge bg-success">

In Stock

</span>

</td>

<td>

<span class="badge bg-danger">

Out Of Stock

</span>

</td>

</tr>













<!-- Rating -->

<tr>

    <td>Rating</td>

    <td>
        <div class="rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>

            <br>

            <small>(4.2/5)</small>
        </div>
    </td>

    <td>
        <div class="rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>

            <br>

            <small>(5.0/5)</small>
        </div>
    </td>

    <td>
        <div class="rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>

            <br>

            <small>(3.4/5)</small>
        </div>
    </td>

</tr>

<!-- Color -->

<tr>

<td>Available Color</td>

<td>

<span class="color black"></span>

<span class="color blue"></span>

<span class="color red"></span>

</td>

<td>

<span class="color brown"></span>

<span class="color black"></span>

</td>

<td>

<span class="color silver"></span>

<span class="color black"></span>

</td>

</tr>

<!-- Size -->

<tr>

<td>Available Size</td>

<td>

<span class="size-box">40</span>

<span class="size-box">41</span>

<span class="size-box">42</span>

<span class="size-box">43</span>

</td>

<td>

<span class="size-box">M</span>

<span class="size-box">L</span>

<span class="size-box">XL</span>

</td>

<td>

<span class="size-box">42mm</span>

<span class="size-box">44mm</span>

</td>

</tr>

<!-- Weight -->

<tr>

<td>Weight</td>

<td>820 gm</td>

<td>620 gm</td>

<td>250 gm</td>

</tr>

<!-- SKU -->

<tr>

<td>SKU</td>

<td>NK-23001</td>

<td>BG-12045</td>

<td>SW-55007</td>

</tr>

<!-- Warranty -->

<tr>

<td>Warranty</td>

<td>12 Months</td>

<td>6 Months</td>

<td>24 Months</td>

</tr>

<!-- Shipping -->

<tr>

<td>Shipping</td>

<td>

<span class="text-success">

<i class="fa-solid fa-truck-fast"></i>

Free Shipping

</span>

</td>

<td>

<span class="text-success">

<i class="fa-solid fa-truck-fast"></i>

Free Shipping

</span>

</td>

<td>

<span class="text-danger">

Paid Shipping

</span>

</td>

</tr>

<!-- Return -->

<tr>

<td>Return Policy</td>

<td>30 Days</td>

<td>15 Days</td>

<td>No Return</td>

</tr>

<!-- Description -->

<tr>

<td>Description</td>

<td>

Premium Nike running shoes with breathable mesh upper and lightweight sole.

</td>

<td>

Stylish leather backpack suitable for office and travel.

</td>

<td>

Advanced smartwatch with heart-rate monitor, GPS and Bluetooth calling.

</td>

</tr>













<tr>

<td>Action</td>

<td>

<button class="btn btn-dark w-100">

<i class="fa fa-cart-shopping"></i>

Add To Cart

</button>

<button class="btn btn-danger w-100 mt-2">

<i class="fa fa-trash"></i>

Remove

</button>

</td>

<td>

<button class="btn btn-dark w-100">
<i class="fa fa-cart-shopping"></i>
Add To Cart

</button>

<button class="btn btn-danger w-100 mt-2">
<i class="fa fa-trash"></i>
Remove

</button>

</td>

<td>

<button class="btn btn-secondary w-100">
<i class="fa fa-cart-shopping"></i>
Out Of Stock

</button>

<button class="btn btn-danger w-100 mt-2">
<i class="fa fa-trash"></i>
Remove

</button>

</td>

</tr>












</tbody>

</table>

</div>

</div>

</section>













 

@endsection