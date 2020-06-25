@extends('layouts.app', ['titlePage' => __('Patients')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">No.</th>
                            <th scope="col" class="sort" data-sort="budget">Name</th>
                            <!--<th scope="col" class="sort" data-sort="status">Gender</th>-->
                            <th scope="col">NRIC / Passport</th>
                            <th scope="col" class="sort" data-sort="branch">Branch</th>
                            <th scope="col">Last Treatment</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($patients as $patient)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                <small>{{ $patient->salutation ?? '' }}</small> {{ $patient->fullname }}
                            </td>
                            <!--<td>
                                {{ $patient->gender }}
                            </td>-->
                            <td>
                              {{ $patient->nric }}
                            </td>
                            <td class="branch">
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

                            <td class="text-left">
                                @if($patient->treats->last()['treat_date'])
                                <a href="{{ route('treat.index', ['patient' => $patient, 'matter' => $patient->treats->sortBy('treat_date')->last()['matter_id']]) }}">
                                  {{ Carbon\Carbon::parse($patient->treats->sortBy('treat_date')->last()['treat_date'])->format('d M Y g:i A') }}
                                </a>
                                @endif
                                <div class="dropdown float-right">
                                    <a class="btn btn-sm btn-info ml-2" href="{{ route('checkin.store', ['patient' => $patient]) }}">Check-In</a>

                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('patient.edit', $patient->id) }}">View / Edit</a>
                                        <a class="dropdown-item" href="{{ route('matter.create', ['patient' => $patient->id])}}"> New Case</a>
                                        <a class="dropdown-item" href="{{ route('matter.index', $patient) }}"> View Case(s)</a>
                                        <!--<a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Something else here</a>-->
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
