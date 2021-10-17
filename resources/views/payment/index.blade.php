@extends('layouts.app', ['titlePage' => $patient->fullname.' Payments'])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div class="mb-2">
            {{-- <a href="{{ route('sources.create') }}" class="btn btn-sm btn-primary">Add New Appointment Source</a> --}}
          </div>

          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">No.</th>
                            <th scope="col" class="sort" data-sort="budget">Date</th>
                            <th scope="col" class="sort" data-sort="budget">Payment ID</th>
                            <th scope="col" class="sort" data-sort="budget">Treat ID</th>
                            <th scope="col" class="sort" data-sort="status">Package/Voucher</th>
                            <th scope="col" class="sort" data-sort="status">Total</th>
                            <th scope="col" class="sort" data-sort="status">Paid</th>
                            <th scope="col" class="sort" data-sort="status">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($patient->payments as $payment)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                    </div>
                                </div>
                            </th>
                            <td>
                              {{ $payment->treat ? Carbon\Carbon::parse($payment->treat->treat_date)->format('d M Y') : Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}
                            </td>
                            <td>
                                {{ $payment->id }}
                            </td>
                            <td>
                                {{ $payment->treat ? $payment->treat->id : "" }}
                            </td>
                            <td>
                                {{ $payment->PatientPackage ? $payment->PatientPackage->variant->name : "" }}
                            </td>
                            <td>
                                RM {{ $payment->total }}
                            </td>
                            <td>
                                RM {{ $payment->paid_amount }}
                            </td>
                            <td class="text-capitalize">
                              {{ $payment->state }}
                            </td>

                            <td class="text-left">
                                <div class="dropdown float-right">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('payment.edit', $payment) }}">View / Edit</a>
                                        <!--<a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Something else here</a>-->
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                  {{-- $patient->payments->links() --}}

            </div>

</div>

        </div>

    </div>


@endsection
