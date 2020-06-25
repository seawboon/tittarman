@extends('layouts.app', ['titlePage' => __('Check-in')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">

          <h3>{{ Session::get('myBranch')->name }} Waiting List</h3>

          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">No.</th>
                            <th scope="col" class="sort" data-sort="budget">Name</th>
                            <th scope="col">State</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($checkins as $key => $checkin)
                        @if($checkin->state=='awaiting')
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                <a href="{{route('patient.edit', ['patient' => $checkin->patient])}}">{{ $checkin->patient->fullname }}</a>
                            </td>
                            <td>
                              {{ $checkin->state }}
                            </td>
                            <td>
                              <a class="btn btn-sm btn-danger ml-2" href="{{ route('checkin.action', ['action'=>'cancelled', 'checkin' => $checkin]) }}">Cancel</a>
                              <a class="btn btn-sm btn-success ml-2" href="{{ route('checkin.action', ['action'=>'paid', 'checkin' => $checkin]) }}">Paid</a>
                            </td>
                        </tr>
                        @endif
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
