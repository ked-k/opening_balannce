<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light bg-primary">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img  src="{{url('images/umeme-logo.png')}}" style="width: 50px" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="{{url('images/umeme-logo.png')}}" style="width: 60px" alt="homepage" class="light-logo" />
                </b>
                <span>
                <img src="{{url('images/umeme-text.png')}}" style="width: 98px" alt="homepage" class="dark-logo" />
                      
              
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav  mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu mailbox animated slideInUp">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <!-- Message -->
                                    <a href="#">
                                        <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                         
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
             
               
                <!-- ============================================================== -->
                <li class="nav-item"> <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" data-toggle="modal" data-target="#NewData"  href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-view-grid"></i>New Record</a>
                  
                </li>
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                </li>
                
               
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{url('assets/images/users/avatar.png')}}" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">                                    
                                    {{-- <div class="u-img"> <span class="round">{{ Auth::user()->getNameInitials() }}</span> <span class="profile-status away pull-right"></span> </div> --}}
                                    <div class="u-img"><img src="{{url('assets/images/users/avatar.png')}}" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{auth()->user()->name}}</h4>
                                        <p class="text-muted">{{auth()->user()->email}}</p><a href="" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"  class="dropdown-item"><i class="fa fa-power-off"></i>
                                <span>Logout</span>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                             </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>