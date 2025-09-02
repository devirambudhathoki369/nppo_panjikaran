<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="24">
                        <span class="logo-txt">{{ env('APP_SHORT') }}</span>
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="24">
                        <span class="logo-txt">{{ env('APP_SHORT') }}</span>
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="24">

                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="24">
                        <span class="logo-txt">{{ env('APP_SHORT') }}</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="btn btn-primary" type="button"><i
                            class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                </button>

                @include('includes.notifications')

            </div> --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item topbar-light bg-light-subtle border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- <img class="rounded-circle header-profile-user"
                        src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar"> --}}
                    <a href="#" class="btn bg-white text-dark rounded-circle">
                        {{ substr(auth()->user()->full_name, 0, 1) }}</a>
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ auth()->user()->full_name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->

                    <div class="dropdown-divider"></div>
                    @if (auth()->user()->user_type == 1)
                        <a class="dropdown-item dropdown-footer" target="_blank" title="Help"
                            href="help\User_Manual_Admin.pdf">
                            <i class="nav-icon fa fa-question-circle"> Help </i>
                        </a>
                    @endif
                    @if (auth()->user()->user_type == 3)
                        <a class="dropdown-item dropdown-footer" target="_blank" title="Help"
                            href="help\User_Manual_DCU.pdf">
                            <i class="nav-icon fa fa-question-circle"> Help </i>
                        </a>
                    @endif
                    @if (auth()->user()->user_type == 4)
                        <a class="dropdown-item dropdown-footer" target="_blank" title="Help"
                            href="help\User_Manual_Vet.pdf">
                            <i class="nav-icon fa fa-question-circle"> Help </i>
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-footer" title="Change Password" href="#">
                        <i class="nav-icon fas fa-user"></i> {{ auth()->user()->name }}
                    </a>
                    <a class="dropdown-item dropdown-footer" title="Notifications"
                        href="{{ route('dataentry.checklists.notifications') }}">
                        <i class="nav-icon fas fa-bell"></i>
                        Notification
                        @php
                            $unreadCount = 0;
                            if (class_exists('App\Models\Notification')) {
                                $unreadCount = \App\Models\Notification::where('to_user_id', auth()->id())
                                    ->where('status', 'unread')
                                    ->count();
                            }
                        @endphp
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                        @endif
                    </a>

                    <a class="dropdown-item dropdown-footer" title="Change Password"
                        href="{{ route('users.change-password', auth()->user()->id) }}">
                        <i class="nav-icon fas fa-key"></i> Change Password
                    </a>


                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
