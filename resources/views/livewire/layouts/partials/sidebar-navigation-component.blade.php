<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-small-cap">Admin</li>
                @if (Auth::user()->hasPermission(['view_reports']))
                    <li> <a class="waves-effect waves-dark" href="{{ route('home') }}"><i class="mdi mdi-gauge"></i><span
                                class="hide-menu">Dashboard </span></a></li>
                @endif

                <li> <a class="waves-effect waves-dark" href="{{ route('projects') }}"><i class="fa fa-fax"></i><span
                            class="hide-menu">Project Lists </span></a></li>
                <li> <a class="waves-effect waves-dark" href="{{ route('trx_categories') }}"><i
                            class="fa fa-fax"></i><span class="hide-menu">Transaction Types</span></a></li>
                <li> <a class="waves-effect waves-dark" href="{{ route('currencies') }}"><i class="fa fa-fax"></i><span
                            class="hide-menu">Currencies </span></a></li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                            class="fa fa-key"></i><span class="hide-menu">Transactions</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('transactions', 'all') }}">All Transactions</a></li>
                        <li><a href="{{ route('transactions', 'income') }}">Income Transactions</a></li>
                        <li><a href="{{ route('transactions', 'Expense') }}">Expense Transactions</a></li>
                    </ul>
                </li>
                @if (Auth::user()->hasPermission(['create_meter_audit']))
                    <li> <a class="waves-effect waves-dark" href="#"><i class="fa fa-file"></i><span
                                class="hide-menu">Reports </span></a></li>
                @endif
                @if (Auth::user()->hasPermission(['access_settings']))
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="fa fa-cogs"></i><span class="hide-menu">Settings</span></a>
                        <ul aria-expanded="false" class="collapse">
                            {{-- <li><a href="{{route('feeders')}}">Feeders</a></li>
                        <li><a href="{{route('meterTypes')}}">Meter Types</a></li>
                        <li><a href="{{route('districts')}}">Districts</a></li>
                        <li><a href="{{route('zones')}}">Zones</a></li>    --}}
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
