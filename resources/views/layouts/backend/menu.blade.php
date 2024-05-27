<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img') }}/musamus.png" class="navbar-logo" alt="logo"
                        style="width: 39px; height:39px; object-fit:cover;">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="{{ url('/') }}" class="nav-link"> {{ env('APP_NAME') }} </a>
            </li>
            <li class="nav-item toggle-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-arrow-left sidebarCollapse">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </li>
        </ul>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Dashboard {{ Auth::user()->role }}</span></div>
            </li>
            <li class="menu {{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ url('/home') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-home bx-sm" style="vertical-align: middle;"></i>
                        <span>Dashboard {{ Auth::user()->role }}</span>
                    </div>
                </a>
            </li>
            @if (Auth::user()->role == 'Admin')
                <li class="menu menu-heading">
                    <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg><span>Master Data</span></div>
                </li>
                <li class="menu {{ request()->is('fakultas') ? 'active' : '' }}">
                    <a href="{{ url('/fakultas') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bx bx-folder bx-sm" style="vertical-align: middle;"></i>
                            <span>Fakultas</span>
                        </div>
                    </a>
                </li>
                <li class="menu menu-heading">
                    <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg><span>Pengguna</span></div>
                </li>
                <li class="menu {{ request()->is('admin') ? 'active' : '' }}">
                    <a href="{{ url('/admin') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                            <span>Admin</span>
                        </div>
                    </a>
                </li>
                <li class="menu {{ request()->is('upt') ? 'active' : '' }}">
                    <a href="{{ url('/upt') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                            <span>Staff UPT</span>
                        </div>
                    </a>
                </li>
                <li class="menu {{ request()->is('mahasiswa') ? 'active' : '' }}">
                    <a href="{{ url('/mahasiswa') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                            <span>Mahasiswa</span>
                        </div>
                    </a>
                </li>
            @elseif(Auth::user()->role =='UPT')
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Pengajuan</span></div>
            </li>
            <li class="menu {{ request()->is('abstrak') ? 'active' : '' }}">
                <a href="{{ url('/abstrak') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                        <span>Data pengajuan</span>
                    </div>
                </a>
            </li>
            @endif
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg><span>Akun</span></div>
            </li>
            <li class="menu {{ request()->is('profile') ? 'active' : '' }}">
                <a href="{{ route('profile') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bx bx-user bx-sm" style="vertical-align: middle;"></i>
                        <span>Profile</span>
                    </div>
                </a>
            </li>

        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
