 <!--HEADER-->
 <header class="topbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="d-flex align-items-center">
                        <!-- دکمه toggle منو -->
                        <div class="topbar-item">
                            <button type="button" class="button-toggle-menu me-2">
                                <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                            </button>
                        </div>
        
                        <!-- عنوان صفحه -->
                        <div class="topbar-item">
                            <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0">داشبورد</h4>
                        </div>
                    </div>
        
                    <div class="d-flex align-items-center gap-1">
        
                        <!-- تم رنگ (روشن/تاریک) -->
                        <div class="topbar-item">
                            <button type="button" class="topbar-button" id="light-dark-mode">
                                <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                            </button>
                        </div>
        
                        <!-- اعلان‌ها -->
        
                    </div>
                </div>
        
            </div>
        </header>

        <div class="main-nav">
            <!-- Sidebar Logo -->
            <div class="logo-box">
                <a href="<?php echo Path::base() . '/admin/'; ?>" class="logo-dark">
                    <img src="<?php echo Path::base() . '/views/admin/'; ?>images/logo-sm.png" class="logo-sm" alt="logo sm">
                    <img src="<?php echo Path::base() . '/views/admin/'; ?>images/logo-dark.png" class="logo-lg" alt="logo dark">
                </a>

                <a href="<?php echo Path::base() . '/admin/'; ?>" class="logo-light">
                    <img src="<?php echo Path::base() . '/views/admin/'; ?>images/logo-sm.png" class="logo-sm" alt="logo sm">
                    <img src="<?php echo Path::base() . '/views/admin/'; ?>images/logo-light.png" class="logo-lg" alt="logo light">
                </a>
            </div>

            <!-- Menu Toggle Button (sm-hover) -->
            <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
                <iconify-icon icon="solar:double-alt-arrow-left-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
            </button>

            <div class="scrollbar" data-simplebar>
                <ul class="navbar-nav" id="navbar-nav">

                    <li class="menu-title">عمومی</li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Path::base() . '/admin/'; ?>">
                            <span class="nav-icon">
                                <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                            </span>
                            <span class="nav-text"> داشبورد </span>
                        </a>
                    </li>
            
                    <li class="menu-title mt-2">کاربران</li>
            
            
                    <li class="nav-item">
                        <a class="nav-link menu-arrow" href="<?php echo Path::base() . '/admin/users/'; ?>#sidebarCustomers" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarCustomers">
                            <span class="nav-icon">
                                <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                            </span>
                            <span class="nav-text">کاربران</span>
                        </a>
                        <div class="collapse" id="sidebarCustomers">
                            <ul class="nav sub-navbar-nav">
                                <li class="sub-nav-item">
                                    <a class="sub-nav-link" href="<?php echo Path::base() . '/admin/users/'; ?>">لیست</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    
                    <li class="menu-title mt-2">پست</li>

                    <li class="nav-item">
                        <a class="nav-link menu-arrow" href="<?php echo Path::base() . '/admin/posts/'; ?>#sidebarMaps" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarMaps">
                            <span class="nav-icon">
                                <iconify-icon icon="solar:streets-map-point-bold-duotone"></iconify-icon>
                            </span>
                            <span class="nav-text">پست ها</span>
                        </a>
                        <div class="collapse" id="sidebarMaps">
                            <ul class="nav sub-navbar-nav">
                                <li class="sub-nav-item">
                                    <a class="sub-nav-link" href="<?php echo Path::base() . '/admin/posts/'; ?>">لیست</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="menu-title mt-2">گزینه ها</li>
                    <li class="nav-item">
                        <a href="<?php echo Path::base(); ?>" class="nav-link" >
                            <span class="nav-text">خانه</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="<?php echo Path::base() . '/logout' ?>" method="post">
                            <button class="nav-link" >
                                <span class="nav-text text-danger">خروج</span>
                            </button>
                        </form>
                    </li>
            
                </ul>
            </div>
        </div>
        <!--HEADER-->