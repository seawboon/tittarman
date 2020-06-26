@extends('layouts.app', ['titlePage' => __('Appointments')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <a class="btn btn-sm btn-info mb-3" href="{{ route('appointments.create') }}">New Appointment</a>

          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">No.</th>
                            <th scope="col" class="sort" data-sort="status">Date & Time</th>
                            <th scope="col" class="sort" data-sort="budget">Name</th>
                            <th scope="col" class="sort" data-sort="price">Contact</th>
                            <th scope="col" class="sort" data-sort="price">Branch & Master</th>
                            <th scope="col">State</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($appos as $appo)
                        <th scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                </div>
                            </div>
                        </th>
                        <td class="budget">
                            <b>{{ Carbon\Carbon::parse($appo->appointment_date)->format('d M Y g:i A') }}</b>
                            <div>
                              <i>{{ $appo->remarks ?? '' }}</i>
                            </div>
                        </td>
                        <td class="budget">
                            <small>{{ $appo->salutation ?? '' }}</small> {{ $appo->name }}
                            @if(!$appo->patient_id)
                            <div>
                              <span class="badge badge-pill badge-primary m-1">New Patient</span>
                            </div>
                            @else
                            <div>
                              <span class="badge badge-pill badge-dark m-1"><a href="{{ route('patient.edit', ['pid'=>$appo->patient_id]) }}">Existing</a></span>
                            </div>
                            @endif
                        </td>
                        <td class="budget">
                            {{ $appo->provider}}-{{ $appo->contact }}
                            <div>
                              <i>{{ $appo->email ?? '' }}</i>
                            </div>
                        </td>
                        <td class="budget">
                            {{ $appo->branch->short}}
                            <div>
                              <i>{{ $appo->user->name ?? '' }}</i>
                            </div>

                        </td>

                        <td class="budget">
                            {{$appo->state}}
                        </td>
                        <td class="budget">
                            <a class="btn btn-sm btn-danger ml-2" href="{{ route('appointments.edit', ['appo'=>$appo]) }}">Edit</a>
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                </table>

                  {{ $appos->links() }}

            </div>

</div>

        </div>

    </div>


@endsection
