<div class="table-responsive">

  <div>
      <table class="table align-items-center">
          <thead class="thead-light">
              <tr>
                  <th scope="col" class="sort" data-sort="name">No.</th>
                  <th scope="col" class="sort" data-sort="budget">Name</th>
                  <th scope="col" class="sort" data-sort="budget">{{ __('ttm.case.title')}}</th>
                  {{--<th scope="col">{{ __('ttm.treat.title')}}</th>--}}
                  <th scope="col">Master</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
              </tr>
          </thead>
          <tbody class="list">
            @foreach($checkins as $key => $checkin)
              @if($checkin->state=='awaiting' or $checkin->state=='treating')
              <tr>
                  <th scope="row" class="align-top">
                      <div class="media align-items-center">
                          <div class="media-body">
                              <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                          </div>
                      </div>
                  </th>
                  <td class="budget align-top">
                      <a href="{{route('patient.edit', ['patient' => $checkin->patient])}}"><small>{{$checkin->patient->salutation}}</small> {{ $checkin->patient->fullname }}</a>
                  </td>
                  <td class="align-top">
                    @if($checkin->matter)
                      <a href="{{ route('matter.edit',['patient' => $checkin->patient, 'matter' => $checkin->matter]) }}">
                      @foreach($checkin->matter->parts as $part)
                        {{$part->part->name}}@if(!$loop->last) + @endif
                      @endforeach
                      </a>
                      <div>
                        {{$checkin->matter->notes}}
                      </div>
                    @endif
                  </td>
                  {{--<td>
                    @if($checkin->matter)
                    @foreach($checkin->matter->treats as $treat)
                    <a class="d-block" href="{{ route('treat.edit', ['patient' => $checkin->patient, 'matter' => $checkin->matter, 'treat' => $treat]) }}">
                      {{ Carbon\Carbon::parse($treat->treat_date)->format('d M Y') }}
                    </a>
                    @endforeach
                    @endif
                  </td>
                  --}}
                  <td class="text-capitalize align-top font-weight-bold">
                    {{ $checkin->user->name ?? ''}}
                  </td>
                  <td class="text-capitalize align-top font-weight-bold">
                    {{ $checkin->state }}
                  </td>
                  <td class="align-top">
                    @if($checkin->state=='awaiting')
                    <a class="btn btn-sm btn-danger ml-2" href="{{ route('checkin.action', ['action'=>'cancelled', 'checkin' => $checkin]) }}">Cancel</a>
                    @role('Master')
                    <a class="btn btn-sm btn-success ml-2" href="{{ route('checkin.action', ['action'=>'treating', 'checkin' => $checkin, 'patient' => $checkin->patient, 'matter' => $checkin->matter, 'user' => auth()->user()]) }}">Treat Now</a>
                    @endrole
                    @endif
                  </td>
                  <td class="align-top px-0">
                    <div class="dropdown float-right">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="{{ route('checkin.edit', $checkin) }}">Edit</a>
                        </div>

                    </div>
                  </td>
              </tr>
              @endif
            @endforeach
          </tbody>
      </table>



  </div>

</div>
