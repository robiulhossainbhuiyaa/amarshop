
   
<header class="header-area header-sticky">

    <div class="container-fluid px-4">

        <nav class="amar-header">

            <!-- Logo -->

            <div class="logo-area">

                <a href="{{ url('/') }}">

                    <img src="{{ asset('assets/images/b.png') }}" alt="AmarShop">

                </a>

            </div>

            <!-- Header Right -->

            <div class="header-right">

                <!-- Categories -->

                <div class="category-area">

                    <button class="category-btn">
                        <i class="fa fa-bars"></i>
                        Categories
                        <i class="fa fa-angle-down"></i>
                    </button>

                    <div class="mega-menu">

                        <ul>

                            <!-- MEN -->
                            <li class="has-child">

                                <a href="#">
                                    Men's Fashion
                                    <i class="fa fa-angle-right"></i>
                                </a>

                                <ul>

                                    <li class="has-child">

                                        <a href="#">
                                            Clothing
                                            <i class="fa fa-angle-right"></i>
                                        </a>

                                        <ul>

                                            <li><a href="#">T-Shirt</a></li>
                                            <li><a href="#">Shirt</a></li>
                                            <li><a href="#">Polo Shirt</a></li>
                                            <li><a href="#">Jeans</a></li>
                                            <li><a href="#">Jacket</a></li>

                                        </ul>

                                    </li>

                                    <li class="has-child">

                                        <a href="#">
                                            Shoes
                                            <i class="fa fa-angle-right"></i>
                                        </a>

                                        <ul>

                                            <li><a href="#">Sneakers</a></li>
                                            <li><a href="#">Running</a></li>
                                            <li><a href="#">Boots</a></li>
                                            <li><a href="#">Sandals</a></li>

                                        </ul>

                                    </li>

                                    <li><a href="#">Watch</a></li>

                                    <li><a href="#">Wallet</a></li>

                                </ul>

                            </li>

                            <!-- WOMEN -->

                            <li class="has-child">

                                <a href="#">
                                    Women's Fashion
                                    <i class="fa fa-angle-right"></i>
                                </a>

                                <ul>

                                    <li><a href="#">Dress</a></li>
                                    <li><a href="#">Makeup</a></li>
                                    <li><a href="#">Jewellery</a></li>
                                    <li><a href="#">Hand Bag</a></li>

                                </ul>

                            </li>

                            <!-- Electronics -->

                            <li>

                                <a href="#">
                                    Electronics
                                </a>

                            </li>

                            <li>

                                <a href="#">
                                    Home & Living
                                </a>

                            </li>

                            <li>

                                <a href="#">
                                    Grocery
                                </a>

                            </li>

                        </ul>

                    </div>

                </div>

                <!-- Search -->

                <div class="search-wrapper">

                    <form action="{{ url('search') }}" method="GET" class="search-area">

                        <input
                            type="text"
                            name="search"
                            id="searchInput"
                            placeholder="Search products, brands and categories...">

                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>

                    </form>

                    <div class="search-dropdown">

                        <div class="search-title">

                            Recent Searches

                        </div>

                        <a href="#">iPhone 16 Pro</a>

                        <a href="#">Gaming Laptop</a>

                        <a href="#">Nike Shoes</a>

                        <hr>

                        <div class="search-title">

                            Trending Products

                        </div>

                        <a href="#">
                            🔥 Smart Watch
                        </a>

                        <a href="#">
                            🔥 Bluetooth Speaker
                        </a>

                        <a href="#">
                            🔥 Men's T-Shirt
                        </a>

                        <a href="#">
                            🔥 Women's Bag
                        </a>

                    </div>

                </div>

                <!-- Right Menu -->

                <div class="right-menu">
 

                    <!-- Wishlist -->

                    <a href="{{ url('wishlist') }}" class="header-icon">

                        <i class="fa-solid fa-heart"></i>

                        <span>2</span>

                    </a>

                    <!-- Compare -->

                    <a href="{{ url('compare') }}" class="header-icon">

                        <i class="fa fa-random"></i>

                        <span>1</span>

                    </a>

                    <!-- Cart -->

                    <!-- Cart -->

                    <div class="cart-dropdown">

                        <a href="#" class="header-cart">

                            <i class="fa fa-shopping-cart"></i>

                            <div>

                                <small>Your Cart</small>

                                <strong>$540</strong>

                            </div>

                            <span class="cart-count">3</span>

                        </a>

                        <div class="mini-cart">

                            <div class="mini-cart-item">

                                <img src="{{ asset('assets/images/men-01.jpg') }}" alt="">

                                <div>

                                    <h6>Classic Spring</h6>

                                    <small>Qty : 1</small>

                                    <strong>$120</strong>

                                </div>

                                <a href="#" class="remove-item">
                                    <i class="fa fa-times"></i>
                                </a>

                            </div>

                            <div class="mini-cart-item">

                                <img src="{{ asset('assets/images/men-02.jpg') }}" alt="">

                                <div>

                                    <h6>Air Force</h6>

                                    <small>Qty : 2</small>

                                    <strong>$180</strong>

                                </div>

                                <a href="#" class="remove-item">
                                    <i class="fa fa-times"></i>
                                </a>

                            </div>

                            <div class="mini-cart-footer">

                                <h5>Total : <span>$540</span></h5>

                                <a href="{{ url('cart') }}" class="btn-cart">
                                    View Cart
                                </a>

                                <a href="{{ url('checkout') }}" class="btn-checkout">
                                    Checkout
                                </a>

                            </div>

                        </div>

                    </div>

                    <!-- ===============================
                                User Account 
                    ==================================-->
                    @if(!session()->get('logged_in'))

                        <div class="user-account">

                            <li class="user-btn"> 
                                <img src="{{ asset('assets/images/b2.png') }}"> 
                                <a href="{{ route('login') }}"  > 
                                    <span>signin</span> 
                                </a> 
                            </li> 
                        </div>



                    @else


                        <div class="user-account">

                            <li class="user-btn">

                                <img src="{{ asset('assets/images/b2.png') }}">

                                <span>{{ $hedardata->username }}</span>

                                <i class="fa fa-angle-down"></i>

                            </li>

                            <div class="user-dropdown">

                                <div class="user-top">

                                    <img src="{{ !empty($hedardata->user_images) ? 
                                    asset('assets/images/$hedardata->user_images') : 
                                    asset('assets/images/b2.png') }}" alt="Image">

                                    <div>

                                        <h5>Mr : {{ $hedardata->full_name }}</h5>

                                        <small>{{ $hedardata->email }}</small>

                                    </div>

                                </div>

                                <hr>
 

                                <a href="#">
                                    <i class="fa fa-user"></i>
                                    My Profile
                                </a>

                                <a href="dashboardView">
                                    <i class="fa fa-gauge-high"></i>
                                    Go to Dashboard
                                </a>

                                <a href="#">
                                    <i class="fa fa-shopping-bag"></i>
                                    My Orders
                                </a>

                                <a href="#">
                                    <i class="fa fa-heart"></i>
                                    Wishlist
                                </a>

                                <a href="#">
                                    <i class="fa fa-map-marker"></i>
                                    Address
                                </a>

                                <a href="#">
                                    <i class="fa fa-cog"></i>
                                    Settings
                                </a>

                                <hr>

                                <a href="{{ route('logout') }}" class="logout">

                                    <i class="fa fa-sign-out"></i>

                                    Logout

                                </a>

                            </div>

                        </div>



                    @endif

                    











                </div>

            </div>

            <!-- Mobile Menu -->

            <button class="mobile-toggle">

                <i class="fa fa-bars"></i>

            </button>

        </nav>

    </div>

</header>