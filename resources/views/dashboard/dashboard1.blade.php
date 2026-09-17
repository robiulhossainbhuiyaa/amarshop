@extends('dashboard.layouts.app')

@section('content')



<div class="container-fluid mt-2">

    <!-- Page Header -->

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

    <div class="row g-4">

        <div class="col-xl-3 col-lg-4 col-md-6">

            <div class="glass-card">

                <div class="card-icon bg-orange">

                    <i class="fa fa-shopping-cart"></i>

                </div>

                <div class="card-info">

                    <h2>152</h2>

                    <span>Total Orders</span>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">

            <div class="glass-card">

                <div class="card-icon bg-green">

                    <i class="fa fa-dollar"></i>

                </div>

                <div class="card-info">

                    <h2>$18,250</h2>

                    <span>Total Revenue</span>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">

            <div class="glass-card">

                <div class="card-icon bg-blue">

                    <i class="fa fa-users"></i>

                </div>

                <div class="card-info">

                    <h2>980</h2>

                    <span>Customers</span>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">

            <div class="glass-card">

                <div class="card-icon bg-red">

                    <i class="fa fa-cubes"></i>

                </div>

                <div class="card-info">

                    <h2>450</h2>

                    <span>Products</span>

                </div>

            </div>

        </div>

    </div>

    @include('dashboard.delivery-tracking')

 
    <div class="row mt-4">

        <!-- Recent Orders -->

        <div class="col-lg-8 mb-4">

            <div class="table-card">

                <div class="table-header">

                    <h5>Recent Orders</h5>

                    <input type="text"
                        class="form-control search-box"
                        placeholder="Search Order">

                </div>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                        <tr>

                            <th>ID</th>

                            <th>Customer</th>

                            <th>Product</th>

                            <th>Amount</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>

                        </thead>

                        <tbody>

                        <tr>

                            <td>#1001</td>

                            <td>Rabiul</td>

                            <td>iPhone 15</td>

                            <td>$1200</td>

                            <td>

                                <span class="status success">

                                    Completed

                                </span>

                            </td>

                            <td>

                                <button class="btn-action">

                                    View

                                </button>

                            </td>

                        </tr>

                        <tr>

                            <td>#1002</td>

                            <td>Karim</td>

                            <td>Headphone</td>

                            <td>$80</td>

                            <td>

                                <span class="status pending">

                                    Pending

                                </span>

                            </td>

                            <td>

                                <button class="btn-action">

                                    View

                                </button>

                            </td>

                        </tr>

                        <tr>

                            <td>#1003</td>

                            <td>Rahim</td>

                            <td>Smart Watch</td>

                            <td>$220</td>

                            <td>

                                <span class="status shipping">

                                    Shipping

                                </span>

                            </td>

                            <td>

                                <button class="btn-action">

                                    View

                                </button>

                            </td>

                        </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Right Widgets -->

        <div class="col-lg-4">

            <!-- Latest Customers -->

            <div class="table-card mb-4">

                <h5 class="mb-3">

                    Latest Customers

                </h5>

                <div class="customer-item">

                    <img src="{{ asset('assets/images/b2.png') }}">

                    <div>

                        <h6>Rabiul</h6>

                        <small>Joined Today</small>

                    </div>

                </div>

                <div class="customer-item">

                    <img src="{{ asset('assets/images/b2.png') }}">

                    <div>

                        <h6>Karim</h6>

                        <small>Yesterday</small>

                    </div>

                </div>

            </div>

            <!-- Delivery Status -->

            <div class="table-card">

                <h5 class="mb-3">

                    Delivery Boys

                </h5>

                <div class="delivery-item">

                    <span>Shakil</span>

                    <span class="online">

                        ● Online

                    </span>

                </div>

                <div class="delivery-item">

                    <span>Rakib</span>

                    <span class="offline">

                        ● Offline

                    </span>

                </div>

            </div>

        </div>

    </div>

 
    



</div>



@endsection