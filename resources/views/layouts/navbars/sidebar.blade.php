<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <!--<img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">-->
            TITTARMAN
        </a>
        <div class="d-none d-md-block">
          @include('layouts.navbars.switch-branches')
        </div>


        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
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
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
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
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <!-- <img src="{{ asset('argon') }}/img/brand/blue.png"> -->
                            TITTARMAN
                        </a>
                    </div>

                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-md-none">
              @include('layouts.navbars.switch-branches')
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none" action="{{ route('patient.search') }}" method="post">
              @csrf
                <div class="input-group input-group-rounded input-group-merge">
                    <input class="form-control" name="search" id="search" placeholder="Search Name / NRIC / Email" type="text" value="{{ $searchTerm ?? '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('checkin.index') }}">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('ttm.todayL') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.create') }}">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('ttm.register') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.index') }}">
                        <i class="ni ni-bullet-list-67 text-pink"></i> {{ __('ttm.patientL') }}
                    </a>
                </li>
                @if(Session::get('myBranch'))
                {{--<li class="nav-item">
                    <a class="nav-link" href="{{ route('appointments.index', ['show'=>'today']) }}">
                        <i class="ni ni-calendar-grid-58 text-pink"></i> {{ __('ttm.appo.title') }}
                    </a>
                </li>--}}
                @endif
                <!--<li class="nav-item">
                    <a class="nav-link" href="{{ route('appointments.index') }}">
                        <i class="ni ni-money-coins text-pink"></i> {{ __('ttm.sales') }}
                    </a>
                </li>-->

                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ni ni-app text-pink"></i> Data
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">

                      <a href="{{ route('users.index') }}" class="dropdown-item">
                          <i class="ni ni-app"></i>
                          <span>{{ __('Users') }}</span>
                      </a>

                      <a href="{{ route('voucher.admin.index') }}" class="dropdown-item">
                          <i class="ni ni-app"></i>
                          <span>Vouchers</span>
                      </a>

                      @role('Admin')
                      <a href="{{ route('roles.index') }}" class="dropdown-item">
                          <i class="ni ni-app"></i>
                          <span>{{ __('Role') }}</span>
                      </a>
                      @endrole

                      <a href="{{ route('methods.index') }}" class="dropdown-item">
                            <i class="ni ni-app"></i>
                            <span>{{ __('Payment Methods') }}</span>
                      </a>

                      <a href="{{ route('sources.index') }}" class="dropdown-item">
                            <i class="ni ni-app"></i>
                            <span>{{ __('Appointment Sources') }}</span>
                      </a>

                      @hasanyrole('Admin|Master')
                      <a href="{{ route('injuryparts.index') }}" class="dropdown-item">
                          <i class="ni ni-app"></i>
                          <span>{{ __('Injury Part') }}</span>
                      </a>
                      @endhasanyrole
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ni ni-app text-pink"></i> Shop
                    </a>
                    @role('Admin')
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                      <a href="{{ route('packages.index') }}" class="dropdown-item">
                            <i class="ni ni-app"></i>
                            <span>{{ __('Packages') }}</span>
                      </a>
                    @endrole
                      <a href="{{ route('products.index') }}" class="dropdown-item">
                            <i class="ni ni-app"></i>
                            <span>{{ __('Products') }}</span>
                      </a>
                    </div>
                </li>

            </ul>
            <!-- Divider -->
            <hr class="my-3">
            @isset($payment->patient)
              @php $patient = $payment->patient; @endphp
            @endisset
            @isset($patient)
              @if(Route::currentRouteName()!='patient.index' && Route::currentRouteName() != 'patient.search')
              <h6 class="navbar-heading text-muted">{{ $patient->fullname }}</h6>
              <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.edit', ['patient' => $patient]) }}">
                        <i class="ni ni-circle-08 text-pink"></i> Profile
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('matter.index', ['patient' => $patient]) }}">
                        <i class="ni ni-badge text-pink"></i> Case(s)
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('voucher.index', ['patient' => $patient]) }}">
                        <i class="ni ni-badge text-pink"></i> Voucher(s)
                    </a>

                </li>
                @can('master-create')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('matter.create', ['patient' => $patient]) }}">
                        <i class="ni ni-fat-add text-pink"></i> New Case
                    </a>
                </li>
                @endcan
                {{--<li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.treats', ['patient' => $patient]) }}">
                        <i class="ni ni-badge text-pink"></i> Treatment(s)
                    </a>
                </li>--}}
              </ul>
              @endif
            @endisset
            <!-- Heading
            <h6 class="navbar-heading text-muted">Documentation</h6>-->
            <!-- Navigation
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>
            </ul>-->
        </div>
    </div>
</nav>


@push('js')

<script>
$(document).on('change','#choose-branch',function(){
  if (this.value!='') {
    //var openURL = "http://"+this.value;
    var openURL = "{{URL::to('/setSession')}}"+"/"+this.value;
    //alert( openURL );
    //window.open(openURL, '_blank');
    window.open(openURL, '_self');
  }
});
</script>

@endpush
