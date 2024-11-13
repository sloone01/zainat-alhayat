<div class="rightbar">
    <!-- Start Topbar Mobile -->
    <div class="topbar-mobile">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="mobile-logobar">
                    <a href="{{url('/')}}" class="mobile-logo"><img src="/assets/images/logo22.jpeg" height="60px" class="img-fluid" alt="logo"></a>
                </div>
                <div class="mobile-togglebar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="topbar-toggle-icon">
                                <a class="topbar-toggle-hamburger" href="javascript:void();">
                                    <img src="/assets/images/svg-icon/horizontal.svg" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                    <img src="/assets/images/svg-icon/verticle.svg" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                 </a>
                             </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="menubar">
                                <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">
                                    <img src="/assets/images/svg-icon/menu.svg" class="img-fluid menu-hamburger-collapse" alt="menu">
                                    <img src="/assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                </a>
                             </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Topbar -->
    <div class="topbar">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start row -->
            <div class="row align-items-center">
                <!-- Start col -->
                <div class="col-md-12 align-self-center">
                    <div class="togglebar">
                        <div class="logobar">
                            <a href="{{url('/')}}" class="logo logo-large"><img src="/assets/images/logo22.jpeg" width="1200" height="200" class="img-fluid" alt="logo"></a>
                        </div>
                    </div>
                    <div class="infobar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="notifybar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('/assets/images/svg-icon/notifications.svg')}}" class="img-fluid" alt="notifications">
                                        <span class="live-icon">{{ sizeof(\App\Providers\GeneralHelper::getNotification()) }}</span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                            <div class="notification-dropdown-title">
                                                <h4>Notifications</h4>
                                            </div>
                                            <ul class="list-unstyled">
                                                @foreach(\App\Providers\GeneralHelper::getNotification() as $note)
                                                    <li class="media dropdown-item">
                                                    <span class="action-icon badge badge-success-inverse">N</span>
                                                    <div class="media-body">
                                                        <h5 class="action-title">{{ $note['title'] }}</h5>
                                                        <p><span class="timing">{{ $note['date'] }}</span></p>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="profilebar">
                                    <div class="dropdown">
                                      <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/assets/images/users/profile.svg" class="img-fluid" alt="profile"><span class="live-icon">{{ auth()->user()->name }}</span><span class="feather icon-chevron-down live-icon"></span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                            <div class="dropdown-item">
                                                <div class="profilename">
                                                  <h5>{{ auth()->user()->name }}</h5>
                                                </div>
                                            </div>
                                            <div class="userbox">
                                                <ul class="list-unstyled mb-0">
{{--                                                    <li class="media dropdown-item">--}}
{{--                                                        <a href="#" class="profile-icon"><img src="{{ asset('/assets/images/svg-icon/crm.svg')}}" class="img-fluid" alt="user">My Profile</a>--}}
{{--                                                    </li>--}}
                                                    <li class="media dropdown-item">
                                                        <a href="{{ route('logout') }}" class="profile-icon"><img src="{{ asset('/assets/images/svg-icon/logout.svg')}}" class="img-fluid" alt="logout">Logout</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item menubar-toggle">
                                <div class="menubar">
                                    <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">
                                        <img src="{{ asset('/assets/images/svg-icon/menu.svg')}}" class="img-fluid menu-hamburger-collapse" alt="menu">
                                        <img src="{{ asset('/assets/images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close">
                                    </a>
                                 </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End Topbar -->
    <!-- Start Navigationbar -->
    <div class="navigationbar">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start Horizontal Nav -->
            <nav class="horizontal-nav mobile-navbar fixed-navbar">
                <div class="collapse navbar-collapse" id="navbar-menu">
                  <ul class="horizontal-menu">
                            <li><a href="{{url('/')}}"><img src="/assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard">Dashboard</a></li>
                            @if(\App\Providers\RoleHelper::haveRole(\App\Providers\RoleHelper::admin))
                                <!-- <li><a href="{{url('/tickets-list')}}"><img src="/assets/images/svg-icon/customers.svg" class="img-fluid" alt="dashboard">Tickets</a></li> -->
                                <li><a href="{{url('/users-list')}}"><img src="{{ asset('/assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="dashboard">Users</a></li>
                                <li><a href="{{url('/criteria-list')}}"><img src="{{ asset('/assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="dashboard">Criterias</a></li>
                                <li><a href="{{url('/classes-list')}}"><img src="{{ asset('/assets/images/svg-icon/dashboard.svg') }}" class="img-fluid" alt="dashboard">Classes</a></li>
                            @endif
                                <li><a href="{{url('/student-list/0')}}"><img src="{{ asset('/assets/images/svg-icon/customers.svg') }}" class="img-fluid" alt="dashboard">Students</a></li>
                                <li><a href="{{url('/reading-list/0')}}"><img src="{{ asset('/assets/images/svg-icon/customers.svg') }}" class="img-fluid" alt="dashboard">Reading</a></li>
                             
                            <!-- @if(\App\Providers\RoleHelper::haveRole(\App\Providers\RoleHelper::dep_admin))
                                <li><a href="{{url('/logs-dep-list')}}"><img src="/assets/images/svg-icon/customers.svg" class="img-fluid" alt="dashboard">Department Logs</a></li>
                            @endif -->


                  </ul>
                </div>
            </nav>
            <!-- End Horizontal Nav -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End Navigationbar -->
    @yield('rightbar-content')
    <!-- Start Footerbar -->
    <div class="footerbar">
        <footer class="footer">
            <p class="mb-0">© OMIFCO Zainat-Alhayat.</p>
        </footer>
    </div>
    <!-- End Footerbar -->
</div>
