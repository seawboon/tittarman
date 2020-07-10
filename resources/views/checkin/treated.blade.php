<div class="table-responsive">

  <div>
      <table class="table align-items-center">
          <thead class="thead-light">
              <tr>
                  <th scope="col" class="sort" data-sort="name">No.</th>
                  <th scope="col" class="sort" data-sort="budget">Name</th>
                  <th scope="col" class="sort" data-sort="budget">{{ __('ttm.case.title')}}</th>
                  <th scope="col" class="sort" data-sort="budget">treatment fee</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
              </tr>
          </thead>
          <tbody class="list">
            @foreach($checkins as $key => $checkin)
              @if($checkin->state!='awaiting')
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

                  <td class="text-capitalize font-weight-bold align-top">
                    @if($checkin->treat)
                      @money($checkin->treat->fee)
                    @endif
                  </td>

                  <td class="text-capitalize font-weight-bold align-top">
                    {{$checkin->state}}
                  </td>

                  <td class="align-top">
                    @if($checkin->state=='awaiting')
                    <a class="btn btn-sm btn-danger ml-2" href="{{ route('checkin.action', ['action'=>'cancelled', 'checkin' => $checkin]) }}">Cancel</a>
                    <a class="btn btn-sm btn-success ml-2" href="{{ route('checkin.action', ['action'=>'treating', 'checkin' => $checkin]) }}">Treat Now</a>
                    @endif
                    @if($checkin->state=='treated')
                    <a class="btn btn-sm btn-warning ml-2" href="{{ route('checkin.action', ['action'=>'paid', 'checkin' => $checkin, 'patient' => $checkin->patient, 'matter' => $checkin->matter, 'treat' => $checkin->treat_id]) }}">Pay</a>
                    @endif
                  </td>
              </tr>
              @endif
            @endforeach
          </tbody>
      </table>



  </div>

</div>
