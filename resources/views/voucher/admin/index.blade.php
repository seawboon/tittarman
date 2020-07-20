@extends('layouts.app', ['titlePage' => __('VOUCHER LIST')])

@section('content')

    <div class="header bg-gradient-Secondary py-6 py-lg-7 vh-100">
        <div class="container-fluid">
          <div class="row">

        <div class="col-xl-12 order-xl-1">
          <div>
            <div class="row pb-3">
              <div class="col-6">
                <div class="btn-group btn-group-sm ml-auto" role="group" aria-label="Basic example">
                  <a href="{{ route('voucher.admin.index', ['show' => 'all']) }}" type="button" class="btn btn-secondary">All</a>
                  <a href="{{ route('voucher.admin.index') }}" type="button" class="btn btn-secondary bg-success text-white">Available</a>
                  <a href="{{ route('voucher.admin.index', ['show' => 'sold']) }}" type="button" class="btn btn-secondary bg-warning text-white">Sold</a>
                  <a href="{{ route('voucher.admin.index', ['show' => 'claimed']) }}" type="button" class="btn btn-secondary bg-danger text-white">Claimed</a>
                </div>
              </div>

            </div>

          </div>

          <div class="table-responsive mt-3">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Code</th>
                                    <th scope="col" class="sort" data-sort="budget">Patient</th>
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
                                                <span class="name mb-0 text-sm">{{ $voucher->id }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget align-top">
                                      <span class="code-{{$loop->iteration}} mr-2">{{ $voucher->code }}</span>
                                      <button class="copyCode border-0 bg-transparent" data-clipboard-action="copy" data-clipboard-target="span.code-{{$loop->iteration}}"><i class="ni ni-single-copy-04"></i></button>
                                    </td>
                                    <td class="budget align-top text-capitalize">
                                      <a href="{{ route('patient.edit', [ 'pid' => $voucher->patient]) }}"><small>{{$voucher->patient->salutation ?? ''}}</small> {{$voucher->patient->fullname ?? ''}}</a>
                                    </td>
                                    <td class="align-top">
                                      <span class="{{ $voucher->state=='enable' ? 'text-success':'text-danger'}}">
                                        {{ $voucher->state }}
                                      </span>

                                    </td>
                                    <td colspan="2" class="align-top">
                                        {{ Carbon\Carbon::parse($voucher->updated_at)->format('d M Y') }}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
        </div>


        @if(empty(request('show')))
          {{ $vouchers->links() }}
        @else
          {{ $vouchers->appends(['show' => request('show')])->links() }}
        @endif


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
