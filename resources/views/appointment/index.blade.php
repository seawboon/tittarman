@extends('layouts.app', ['titlePage' => __('Appointments')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div>
            <a class="btn btn-sm btn-info mb-3" href="{{ route('appointments.create') }}">New Appointment</a>
            <div class="row pb-3">
              <div class="col-6">
                <div class="btn-group btn-group-sm ml-auto" role="group" aria-label="Basic example">
                  <a href="{{ route('appointments.index', ['show' => 'all']) }}" type="button" class="btn btn-secondary">All</a>
                  <a href="{{ route('appointments.index', ['show' => 'today']) }}" type="button" class="btn btn-secondary">Today</a>
                </div>
              </div>

              <div class="col-6 text-align-right">
                <form class="navbar-search navbar-search-dark form-inline d-none d-md-flex ml-auto" action="{{ route('appointments.range') }}" method="POST" autocomplete="off">
                  @csrf
                    <div class="form-group mb-0 ml-auto">
                        <div class="input-group input-group-alternative bg-primary">
                            <div class="input-group-prepend">
                                <span class="input-group-text-sm"><i class="fas fa-search" style="font-size: 0.875rem; margin-top: 0.5rem; margin-left: 0.5rem;"></i></span>
                            </div>
                            <input class="form-control-sm flatpickr datetimepicker pl-2" name="dateRange" id="dateRange" placeholder="Date Range" type="text" value="{{ $searchTerm ?? '' }}">
                        </div>

                    </div>
                    <button type="submit" class="btn-sm btn-primary">Search</button>
                </form>
              </div>

            </div>

          </div>

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
                          @if($appo->state == 'awaiting')
                            @if($appo->patient_id)
                            <a class="btn btn-sm btn-info ml-2" href="{{ route('checkin.appointment', ['patient' => $appo->patient_id, 'appo' => $appo, 'matter' => $appo->matter_id]) }}">Check-In</a>
                            @else
                            <a class="btn btn-sm btn-info ml-2" href="{{ route('patient.create', ['appo' => $appo]) }}">Register & Check In</a>
                            @endif
                          @endif
                            <a class="btn btn-sm btn-danger ml-2" href="{{ route('appointments.edit', ['appo'=>$appo]) }}">Edit</a>
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                </table>


                  @if(empty(request('show')))
                    {{ $appos->links() }}
                  @else
                    {{ $appos->appends(['show' => request('show')])->links() }}
                  @endif
            </div>

</div>



        </div>

    </div>


@endsection

@push('css')
<style>
.form-control-sm{
  background-color: transparent;
  outline:0;
  border: 0;
  color: rgba(255, 255, 255, .9);
}

.form-control-sm::placeholder, .input-group-text-sm
{
  color: rgba(255, 255, 255, .75);
}

</style>
@endpush

@push('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function() {
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
    mode: "range",
    enableTime: false,
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    //defaultDate: ['2020-07-09 00:00:00', '2020-07-19 00:00:00'],
    /*disable: [
        function(date) {
            // disable every multiple of 8
            return !(date.getDate() % 8);
        }
    ]*/
  });


});
</script>

@endpush
