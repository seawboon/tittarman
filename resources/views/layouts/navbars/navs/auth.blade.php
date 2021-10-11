<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <h4 class="mb-0 text-capitalize d-none d-lg-inline-block">{{ $titlePage ?? '' }}</h4>
        <!--<h4 class="mb-0 text-uppercase d-none d-lg-inline-block">
          <a href="{{ route('patient.create') }}" class="btn btn-icon btn-outline-primary" type="button">
          	<span class="btn-inner--icon"><i class="ni ni-circle-08 text-pink"></i></span>
              <span class="btn-inner--text">New Patient</span>
          </a>
        </h4>-->
        <!-- Form -->
        <div class="d-none d-md-flex ml-md-auto position-relative">
          <i class="fas fa-search ttm-search"></i>
          <div class="search-form bg-primary rounded pt-3 pl-3 pb-2">
            @include('layouts.navbars.navs.searchform')
          </div>
        </div>

        <!-- User -->
        <!--
        <a class="nav-link" href="{{ route('patient.index') }}">
            <i class="ni ni-bullet-list-67 text-pink"></i> {{ __('Patients') }}
        </a>
      -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">

                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm text-default font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <!--<a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>-->
                    @hasanyrole('Admin|Master')
                    <a href="{{ route('user.appointment')}}" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('My Appointment') }}</span>
                    </a>
                    @endhasanyrole
                    <!--<a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>-->
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
