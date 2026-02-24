<header class="nxl-header">
    <div class="header-wrapper">
        <!--! [Start] Header Left !-->
        <div class="header-left d-flex align-items-center gap-4">
            <!--! [Start] nxl-head-mobile-toggler !-->
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <!--! [Start] nxl-head-mobile-toggler !-->
            <!--! [Start] nxl-navigation-toggle !-->
            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="feather-arrow-right"></i>
                </a>
            </div>
            <!--! [End] nxl-navigation-toggle !-->
        </div>
        <!--! [End] Header Left !-->
        <!--! [Start] Header Right !-->
        <div class="header-right ms-auto">
            <div class="d-flex align-items-center">
                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        <img src="{{ asset('back/assets/images/avatar/1.png') }}" alt="user-image"
                            class="img-fluid user-avtar me-0" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('back/assets/images/avatar/1.png') }}" alt="user-image"
                                    class="img-fluid user-avtar" />
                                <div>
                                    <h6 class="text-dark mb-0">{{ Auth::user()->name ?? 'Administrator' }} <span
                                            class="badge bg-soft-primary text-primary ms-1">PRO</span></h6>
                                    <span
                                        class="fs-12 fw-medium text-muted">{{ Auth::user()->email ?? 'admin@example.com' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.profile.show') }}" class="dropdown-item">
                            <i class="feather-user"></i>
                            <span>Profile Details</span>
                        </a>
                        <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">
                            <i class="feather-settings"></i>
                            <span>Account Settings</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <a href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                                <i class="feather-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--! [End] Header Right !-->
    </div>
</header>
