@if (Auth::user()->hasPermission(['access_user_management_module']))
    <li href="#" aria-expanded="false">
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bx bx-group"></i>
            </div>
            <div class="menu-title">{{ __('public.usermgt') }}</div>
        </a>
        <ul aria-expanded="false" class="collapse">  
            <li> <a href="{{ route('usermanagement') }}"><i class="bx bx-right-arrow-alt"></i>{{ __('public.users') }}</a>
            </li>
            <li> <a href="{{ route('user-roles.index') }}"><i
                        class="bx bx-right-arrow-alt"></i>{{ __('public.roles') }}</a>
            </li>
            <li> <a href="{{ route('user-permissions.index') }}"><i
                        class="bx bx-right-arrow-alt"></i>{{ __('public.permissions') }}</a>
            </li>
            <li> <a href="{{ route('user-roles-assignment.index') }}"><i
                        class="bx bx-right-arrow-alt"></i>{{ __('public.roleassign') }}</a>
            </li>
            <li> <a href="{{ route('logs') }}"><i
                        class="bx bx-right-arrow-alt"></i>{{ __('public.loginactivity') }}</a>
            </li>
            <li> <a href="{{ route('useractivity') }}"><i
                        class="bx bx-right-arrow-alt"></i>{{ __('public.useractivity') }}</a>
            </li>
        </ul>
    </li>
@endif
