<div class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
      <div>
          <img src="{{ asset('assets/images/merp-logo.png') }}" class="logo-icon" alt="logo icon">
      </div>
      <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
      </div>
  </div>
  <!--navigation-->
  <ul class="metismenu" id="menu">
      <li>
          <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><i class='bx bx-home-circle'></i>
              </div>
              <div class="menu-title">{{ __('public.home') }}</div>
          </a>
          <ul>
              <li> <a href="{{ route('human-resource-dashboard') }}"><i
                          class="bx bx-right-arrow-alt"></i>{{ __('public.dashboard') }}</a>
              </li>
          </ul>
      </li>
{{-- 
      <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-buildings'></i>
            </div>
            <div class="menu-title">{{ __('Company Profile') }}</div>
        </a>
        <ul>
            <li> <a href="{{ route('company-profile') }}"><i
                        class="bx bx-right-arrow-alt"></i>{{ __('Profile') }}</a>
            </li>
        </ul>
    </li> --}}

  </ul>
  <!--end navigation-->
</div>
