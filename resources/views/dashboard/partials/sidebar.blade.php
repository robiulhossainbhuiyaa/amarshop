<aside class="sidebar  " id="sidebar">

    <!-- Sidebar Header -->

    <div class="sidebar-top">

        <button id="sidebarToggle">

            <i class="fa fa-bars"></i>

        </button>

        <div class="sidebar-logo">

            <img src="{{ asset('assets/images/b.png')}}" alt="">

        </div>

    </div>

    <!-- User -->

    <div class="sidebar-user">
 
        <img src="{{ !empty($hedardata->user_images) ? 
        asset('assets/images/$hedardata->user_images') : 
        asset('assets/images/b2.png') }}" alt="Image">
        <div class="user-info"> 
            <h5>{{ $hedardata->full_name }}</h5>  
        </div>

    </div>

    <!-- Menu -->

    <style>
        .sub-menu {
            display: none;
        }

        .has-sub.open > .sub-menu,
        .sub-menu.open {
            display: block;
        }
    </style>

    <ul class="sidebar-menu">
    

        <!-- ========================= -->
         
        <!-- ========================= -->

        @foreach($sidebarmenuData as $menurslt)

            @php
                $currentpag = trim(request()->path(), '/');
                $menuPath = trim($menurslt->menu_link, '/');

                $hasSubMenu = $menurslt->subMenus->count() > 0;

                $isActive = $menuPath === $currentpag;

                $hasActiveSubMenu = $menurslt->subMenus->contains(function ($submenu) use ($currentpag) {
                    return trim($submenu->menu_link, '/') === $currentpag;
                });

                $menuOpen = $isActive || $hasActiveSubMenu;
            @endphp


            <li class="
                {{ $hasSubMenu ? 'has-sub' : '' }}
                {{ $menuOpen ? 'active open' : '' }}
            ">

                @if($hasSubMenu)

                    {{-- Parent with submenu --}}
                    <a href="javascript:void(0);" class="menu-toggle">

                @else

                    {{-- Normal menu --}}
                    <a href="{{ url($menurslt->menu_link) }}"
                    class="{{ $isActive ? 'active' : '' }}">

                @endif

                    <i class="{{ $menurslt->menu_icon }}"></i>

                    <span>{{ $menurslt->menu_name }}</span>

                    @if($hasSubMenu)
                        <i class="fa fa-angle-down submenu-arrow"></i>
                    @endif

                </a>


                @if($hasSubMenu)

                    <ul class="sub-menu {{ $menuOpen ? 'open' : '' }}">

                        @foreach($menurslt->subMenus as $submenu)

                            @php
                                $submenuActive =
                                    trim($submenu->menu_link, '/') === $currentpag;
                            @endphp

                            <li class="{{ $submenuActive ? 'active' : '' }}">

                                <a href="{{ url($submenu->menu_link) }}">

                                    <i class="{{ $submenu->menu_icon }}"></i>

                                    {{ $submenu->menu_name }}

                                </a>

                            </li>

                        @endforeach

                    </ul>

                @endif

            </li>

        @endforeach


        <script>
            $(document).on('click', '.has-sub > .menu-toggle', function (e) {

                e.preventDefault();
                e.stopPropagation();

                const parent = $(this).closest('.has-sub');
                const submenu = parent.children('.sub-menu');

                parent.toggleClass('open');
                submenu.toggleClass('open');

            });    

        </script>

         
 

        <!-- ========================= -->
         
        <!-- ========================= -->
 












    </ul>

</aside>