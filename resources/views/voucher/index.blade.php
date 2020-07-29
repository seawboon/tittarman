@extends('layouts.app', ['titlePage' => __(' VOUCHER LIST')])

@section('content')

    <div class="header bg-gradient-Secondary py-6 py-lg-7 vh-100">
        <div class="container-fluid">
          <div class="row">

        <div class="col-xl-12 order-xl-1">

          <h3><small>{{$patient->salutation}}</small> {{$patient->fullname}}</h3>
          <div class="table-responsive mt-3">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Code</th>
                                    <th scope="col" class="sort" data-sort="status">Status</th>
                                    <th scope="col" class="sort" data-sort="status">Date</th>
                                    <th scope="col" class="sort" data-sort="branch" style="width:40px !important; padding: .75rem 0"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($vouchers as $voucher)
                                <tr>
                                    <th scope="row" class="align-top">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget align-top">
                                      <span class="code-{{$loop->iteration}} mr-2">{{ $voucher->code }}</span>
                                      <button class="copyCode border-0 bg-transparent" data-clipboard-action="copy" data-clipboard-target="span.code-{{$loop->iteration}}"><i class="ni ni-single-copy-04"></i></button>
                                    </td>
                                    <td class="align-top">
                                      <span class="{{ $voucher->state=='enable' ? 'text-success':'text-danger'}}">
                                        {{ $voucher->state }}
                                      </span>

                                    </td>
                                    <td colspan="2" class="align-top">
                                        {{ Carbon\Carbon::parse($voucher->updated_at)->format('d M Y') }}
                                    </td>
                                    <td class="align-top px-0">
                                      @if($voucher->state == 'enable')
                                      <div class="dropdown float-right">
                                          <!--<a class="btn btn-sm btn-info ml-2" href="{{ route('checkin.store', ['patient' => $patient]) }}">{{ __('ttm.checkin')}}</a>-->

                                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                              <a class="dropdown-item" href="{{ route('voucher.transfer', ['patient'=>$patient, 'voucher' => $voucher]) }}">Transfer Voucher</a>
                                          </div>

                                      </div>
                                      @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
        </div>


        {{ $vouchers->links() }}


        </div>


        </div>

        </div>

    </div>



@endsection

@push('js')
<script src="{{asset('js/clipboard.min.js')}}"></script>
<script>
var clipboard = new ClipboardJS('.copyCode');

clipboard.on('success', function(e) {
    console.log(e);
});

clipboard.on('error', function(e) {
    console.log(e);
});
</script>
@endpush
