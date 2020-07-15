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
            @foreach($payments as $key => $payment)
              <tr>
                  <th scope="row" class="align-top">
                      <div class="media align-items-center">
                          <div class="media-body">
                              <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                          </div>
                      </div>
                  </th>
                  <td class="budget align-top">
                      <a href="{{route('patient.edit', ['patient' => $payment->patient_id])}}"><small>{{$payment->patient->salutation}}</small> {{ $payment->patient->fullname }}</a>
                  </td>
                  <td class="align-top">
                    @if($payment->matter_id)
                      <a href="{{ route('matter.edit',['patient' => $payment->patient_id, 'matter' => $payment->matter_id]) }}">
                      @foreach($payment->matter->parts as $part)
                        {{$part->part->name}}@if(!$loop->last) + @endif
                      @endforeach
                      </a>
                    @endif
                  </td>

                  <td class="text-capitalize font-weight-bold align-top">
                      @money($payment->treatment_fee + $payment->product_amount - $payment->discount)
                  </td>

                  <td class="text-capitalize font-weight-bold align-top">
                    @if($payment->state == 'paid')
                      {{$payment->state}}
                    @else
                      <a class="btn btn-sm btn-success ml-2" href="{{ route('payment.edit', $payment) }}">Pay Now</a>
                    @endif
                  </td>

                  <td class="align-top px-0">
                    <div class="dropdown float-right">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="{{ route('payment.edit', $payment) }}">Edit</a>
                        </div>

                    </div>
                  </td>

              </tr>
            @endforeach
          </tbody>
      </table>



  </div>

</div>
