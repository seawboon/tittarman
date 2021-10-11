@extends('layouts.app', ['titlePage' => __(' Treatment')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


            <div class="col-xl-4 order-xl-2">
             @include('treat.card')
            </div>

        <div class="col-xl-8 order-xl-1">
          <div class="table-responsive">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Treat Date & Time</th>
                                    <th scope="col" class="sort" data-sort="status">Treatment</th>
                                    <th scope="col" class="sort" data-sort="branch">Remarks</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($matter->treats as $treat)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{ Carbon\Carbon::parse($treat->treat_date)->format('d M Y g:i A') }}
                                    </td>
                                    <td class="budget">
                                        {{ $treat->treatment }}
                                    </td>

                                    <td>
                                        {{ $treat->remarks }}
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{ route('treat.edit', ['patient' => $patient, 'matter' => $matter, 'treat' => $treat]) }}">View / Edit</a>
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


        <div class="text-center">
          <a href="{{ route('treat.create', ['patient' => $patient, 'matter' => $matter]) }}" class="btn btn-sm btn-primary">Add New Treatment</a>
        </div>


        </div>


        </div>

        </div>

    </div>


@endsection
