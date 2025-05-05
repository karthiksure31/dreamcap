<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="../assets/images/users/user-6.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark font-weight-normal dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">Stanley Parker</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>
                @if (Auth::user()->role_id == 1)
                <li>
                    <a href="{{ route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard</span>
                    </a>
                </li>
                <li class="menu-title mt-2">Menus</li>
                <li>
                    <a href="{{ route('admin.series.index')}}" class="nav-link {{ (request()->is('admin/series*')) ? 'active' : '' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                            <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span> Series </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.teams.index')}}" class="nav-link {{ (request()->is('admin.teams*')) ? 'active' : '' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                            <path d="M6 12H18" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <span> Teams </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.players.index')}}" class="nav-link {{ (request()->is('admin/players*')) ? 'active' : '' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" />
                            <path d="M6 20V18C6 15.79 7.79 14 10 14H14C16.21 14 18 15.79 18 18V20" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <span> Players </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.matchschedule.index')}}" class="nav-link {{ (request()->is('admin.matchschedule*')) ? 'active' : '' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="16" stroke="currentColor" stroke-width="2" />
                            <path d="M3 8H21" stroke="currentColor" stroke-width="2" />
                            <path d="M8 12H16" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <span> Match Schedules </span>
                    </a>
                </li>
                @endif
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->