<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
     
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                 <li class="nav-devider"></li>
                <li class="nav-small-cap">Admin</li>
                @if (Auth::user()->hasPermission(['view_reports']))
                <li> <a class="waves-effect waves-dark" href="{{route('home')}}"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a></li>
                @endif
                @if (Auth::user()->hasPermission(['create_meter_audit']))
                <li> <a class="waves-effect waves-dark" href="{{route('audits')}}"><i class="fa fa-fax"></i><span class="hide-menu">Field Audits </span></a></li>
                @endif
                @if (Auth::user()->hasPermission(['receive_meter']))
                <li> <a class="waves-effect waves-dark" href="{{route('official.audit')}}"><i class="fa fa-vcard-o"></i><span class="hide-menu">Received Meters </span></a></li>
                @endif
                @if (Auth::user()->hasPermission(['create_meter_audit']))
                <li> <a class="waves-effect waves-dark" href="{{route('official.issued')}}"><i class="fa fa-vcard-o"></i><span class="hide-menu">Issued Meters </span></a></li>
                @endif
                @if (Auth::user()->hasPermission(['access_key_centre']))
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-key"></i><span class="hide-menu">Key Request</span></a>
                    <ul aria-expanded="false" class="collapse">  
                        <li><a href="{{route('keyRequests')}}">Requests</a></li>
                        <li><a href="{{route('nonAmrKeys')}}">Non AMR Keys</a></li>                      
                        <li><a href="{{route('clusteredBoxKeys')}}">Clustered Box Keys</a></li>               
                    </ul>
                </li>
                @endif
                @if (Auth::user()->hasPermission(['create_meter_audit']))
                <li> <a class="waves-effect waves-dark" href="{{route('admin.reports')}}"><i class="fa fa-file"></i><span class="hide-menu">Reports </span></a></li>
                @endif
                @if (Auth::user()->hasPermission(['access_settings']))
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">  
                        <li><a href="{{route('feeders')}}">Feeders</a></li>
                        <li><a href="{{route('meterTypes')}}">Meter Types</a></li>                      
                        <li><a href="{{route('districts')}}">Districts</a></li>                      
                        <li><a href="{{route('zones')}}">Zones</a></li>   
                        @if (Auth::user()->hasPermission(['create_user']))                   
                        @include('livewire.layouts.partials.inc.user-mgt-nav')
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>