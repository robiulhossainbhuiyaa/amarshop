@extends('front.layouts.app')

@section('contant')



    @include('front.home.hero')

    @include('front.home.categories')

    @include('front.home.flash-sale')

    @include('front.home.featured')

    @include('front.home.new-arrival')

    @include('front.home.offer-banner')

    @include('front.home.trending-products')

    @include('front.home.brands')

    @include('front.home.why-choose')

    @include('front.home.testimonials')

    @include('front.home.instagram-gallery')

     

    <div class="m-4" id="top">  </div>
 
    
    <!-- ***** Men Area Starts ***** -->
    <section class="section" id="men">
        <div class="section-heading text-center mb-5">

            <span class="sub-title">
                TRENDING PRODUCTS
            </span>

            <h2>
                Our's Collection
            </h2>

            <p>
                Discover our latest premium fashion collection.
            </p>

        </div> 
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="men-item-carousel">
                        <div class="owl-men-item owl-carousel">
                            <div class="item">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="single-product"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-star"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img src="./assets/images/men-01.jpg" alt="">
                                </div>
                                <div class="down-content">
                                    <h4>Classic Spring</h4>
                                    <span>$120.00</span>
                                    <ul class="stars">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item  ">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="single-product"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-star"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img src="./assets/images/men-02.jpg" alt="">
                                </div>
                                <div class="down-content">
                                    <h4>Air Force 1 X</h4>
                                    <span>$90.00</span>
                                    <ul class="stars">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item  ">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="single-product"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-star"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img src="./assets/images/men-03.jpg" alt="">
                                </div>
                                <div class="down-content">
                                    <h4>Love Nana ‘20</h4>
                                    <span>$150.00</span>
                                    <ul class="stars">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item  ">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="single-product"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-star"></i></a></li>
                                            <li><a href="single-product"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img src="./assets/images/men-01.jpg" alt="">
                                </div>
                                <div class="down-content">
                                    <h4>Classic Spring</h4>
                                    <span>$120.00</span>
                                    <ul class="stars">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Men Area Ends ***** -->
    
 

  
 



@endsection