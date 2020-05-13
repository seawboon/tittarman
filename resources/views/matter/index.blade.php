@extends('layouts.app', ['titlePage' => __(' Case')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('matter.card')
          </div>

        <div class="col-xl-8 order-xl-1">
          <div class="table-responsive">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Injury Part</th>
                                    <th scope="col" class="sort" data-sort="status">Injury Since</th>
                                    <th scope="col" class="sort" data-sort="branch">Treatment</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($patient->matters as $matter)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ $matter->injury_part }}
                                        <div>
                                          <i>{{ $matter->remarks ?? '' }}</i>
                                        </div>
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($matter->injury_since)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('treat.index', ['patient' => $patient, 'matter' => $matter]) }}" class="badge badge-md badge-circle badge-floating badge-default border-white">{{ count($matter->treats)}}</a>


                                      @if($matter->treats->last()['treat_date'])
                                      <a href="{{ route('treat.index', ['patient' => $patient, 'matter' => $matter->treats->sortBy('treat_date')->last()['matter_id']]) }}">
                                        {{ Carbon\Carbon::parse($matter->treats->sortBy('treat_date')->last()['treat_date'])->format('d M Y g:i A') }}
                                      </a>
                                      @endif

                                        <div class="dropdown float-right">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{ route('matter.edit', ['patient' => $patient, 'matter' => $matter]) }}">View / Edit</a>
                                                <a class="dropdown-item" href="{{ route('treat.create', ['patient' => $patient, 'matter' => $matter])}}"> Add Treatment</a>
                                                <!--<a class="dropdown-item" href="#">View</a>
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
          <a href="{{ route('matter.create', ['patient' => $patient]) }}" class="btn btn-sm btn-info">Add New Case</a>
        </div>

        </div>


        </div>

        </div>

    </div>


@endsection
