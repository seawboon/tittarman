@extends('layouts.app', ['titlePage' => __('Patients')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Patient ID</th>
                            <th scope="col" class="sort" data-sort="budget">Name</th>
                            <th scope="col" class="sort" data-sort="budget">Contact</th>
                            <th scope="col" class="sort" data-sort="branch">Branch</th>
                            <th scope="col">{{ __('ttm.case.title') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($patients as $patient)
                        <tr>
                            <th scope="row" class="align-top">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$patient->id}}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget align-top">
                                <a href="{{ route('patient.edit', $patient->id) }}"><small>{{ $patient->salutation ?? '' }}</small> {{ $patient->fullname }}</a>
                                <br />{{ $patient->nric }}
                            </td>
                            <td>
                                {{ $patient->provider.$patient->contact }}
                            </td>
                            <td class="branch align-top">
                                {{ $patient->branch->short }}
                            </td>
                            <!--<td>
                                <div class="d-flex align-items-center">
                                    <span class="completion mr-2">60%</span>
                                    <div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                              <a href="{{ route('matter.index', $patient) }}" class="badge badge-md badge-circle badge-floating badge-default border-white">{{ count($patient->matters) }}</a>
                            </td>-->

                            <td class="text-left align-top">
                                <ul class="navbar-nav">
                                  @if($patient->matters->isNotEmpty())
                                    @foreach($patient->matters as $matter)
                                      <li class="nav-item">
                                        <a class="nav-link d-inline float-left" href="{{ route('matter.edit', ['patient'=>$patient, 'matter'=>$matter]) }}">
                                        {{$loop->iteration}}.
                                        @foreach($matter->parts as $part)
                                          {{$part->part->name}}@if(!$loop->last) + @endif
                                        @endforeach
                                        </a>
                                        <a class="btn btn-sm btn-info float-right" href="{{ route('appointments.create', ['patient' => $patient, 'matter' => $matter]) }}">Make Appointment</a>
                                        <a class="btn btn-sm btn-info float-right" href="{{ route('checkin.create', ['patient' => $patient, 'matter' => $matter]) }}">{{ __('ttm.checkin')}}</a>
                                        <div class="py-1" style="clear:both"></div>
                                      </li>
                                    @endforeach
                                  @endif
                                  <li class="nav-item">
                                    <a class="btn btn-sm btn-info float-right" href="{{ route('checkin.create', ['patient' => $patient]) }}">New Case Check-In</a>
                                    {{--<a class="btn btn-sm btn-info float-right mr-2" href="{{ route('appointments.create', ['patient' => $patient]) }}">New Case Appointment</a>--}}
                                  </li>
                                </ul>

                                {{--
                                @if($patient->treats->last()['treat_date'])
                                <a href="{{ route('treat.index', ['patient' => $patient, 'matter' => $patient->treats->sortBy('treat_date')->last()['matter_id']]) }}">
                                  {{ Carbon\Carbon::parse($patient->treats->sortBy('treat_date')->last()['treat_date'])->format('d M Y g:i A') }}
                                </a>
                                @endif
                                --}}


                            </td>

                            <td class="align-top px-0">
                              <div class="dropdown float-right">
                                  <!--<a class="btn btn-sm btn-info ml-2" href="{{ route('checkin.store', ['patient' => $patient]) }}">{{ __('ttm.checkin')}}</a>-->

                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      <a class="dropdown-item" href="{{ route('appointments.create', ['patient' => $patient]) }}">New Case Appointment</a>
                                      <a class="dropdown-item" href="{{ route('payment.create', ['patient' => $patient]) }}">Make Payment</a>
                                      <div class="dropdown-divider"></div>
                                      <div class=" dropdown-header noti-title">
                                          <h4 class="text-overflow m-0">Case</h4>
                                      </div>
                                      <a class="dropdown-item" href="{{ route('matter.index', $patient) }}"> {{ __('ttm.case.view')}}</a>
                                      @role('Master')<a class="dropdown-item" href="{{ route('matter.create', ['patient' => $patient->id])}}"> {{ __('ttm.case.add')}}</a>@endrole
                                  </div>

                              </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                @if(empty($searchTerm))
                  {{ $patients->links() }}
                @else
                  {{ $patients->appends(['search' => $searchTerm])->links() }}
                @endif

            </div>

</div>

<!--
<div class="text-center">
  <a href="{{ route('patient.create') }}" class="btn btn-sm btn-primary">Add New Patient</a>
</div>
-->
        </div>

    </div>


@endsection
