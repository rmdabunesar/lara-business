<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Pages</li>

                <li>
                    <a href="#review" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Review Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="review">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.review') }}" class="tp-link">All Review</a>
                            </li>
                            <li>
                                <a href="{{ route('add.review') }}" class="tp-link">Add Review</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#slider" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Slider Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="slider">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('get.slider') }}" class="tp-link">Get Slider</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">General</li>

                <li>
                    <a href="#feature" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Features Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="feature">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.feature') }}" class="tp-link">All Features</a>
                            </li>
                            <li>
                                <a href="{{ route('add.feature') }}" class="tp-link">Add Features</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#clarifies" data-bs-toggle="collapse">
                        <i data-feather="cpu"></i>
                        <span> Clarifies Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="clarifies">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.clarifies') }}" class="tp-link">Get Clarifies</a>
                            </li>
                            <li>
                                <a href="{{ route('add.clarifies') }}" class="tp-link">Add Clarifies</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#usabilities" data-bs-toggle="collapse">
                        <i data-feather="award"></i>
                        <span> Usabilities Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="usabilities">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.usabilities') }}" class="tp-link">Get Usabilities</a>
                            </li>
                            <li>
                                <a href="{{ route('add.usabilities') }}" class="tp-link">Add Usabilities</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
