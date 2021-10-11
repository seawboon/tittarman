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
                            <th scope="col" class="sort" data-sort="branch">Branch</th>
                            <th scope="col" class="sort" data-sort="budget">treat_date</th>
                            <th scope="col" class="sort" data-sort="status">treatment</th>
                            <th scope="col">remarks</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($patient->treats as $treat)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                    </div>
                                </div>
                            </th>

                            <td class="branch">
                                {{ $treat->branch->short }}
                            </td>

                            <td class="budget">
                                {{ Carbon\Carbon::parse($treat->treat_date)->format('d M Y g:i A') }}
                            </td>
                            <td>
                                {{ $treat->treatment }}
                                @if($treat->remarks)
                                  <small class="d-block">{{ $treat->remarks }}</small>
                                @endif
                            </td>
                            <td>
                              {{ $treat->remarks }}
                            </td>


                            <td>
                              <a href="{{ route('matter.edit', ['patient' => $patient, 'matter' => $treat->matter]) }}" class="badge badge-md badge-circle badge-floating badge-default border-white">C</a>
                            </td>

                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('treat.edit', ['patient' => $patient, 'matter' => $treat->matter, 'treat' => $treat]) }}">View / Edit</a>
                                        <a class="dropdown-item" href="{{ route('treat.create', ['patient' => $patient, 'matter' => $treat->matter]) }}">Add Treatment</a>
                                        <!--<a class="dropdown-item" href="{{ route('matter.create', ['patient' => $patient->id])}}"> Add Treatment</a>
                                        <a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Something else here</a>-->
                                    </div>

                                </div>
                            </td>


                        </tr>
                        @endforeach

                    </tbody>
                </table>


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
