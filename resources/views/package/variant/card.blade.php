    <div class="container">
      <div class="mb-2 text-right">
        <a href="{{ route('add.variant', $package) }}" class="btn btn-sm btn-primary">Add New Variant</a>
      </div>

      <div class="table-responsive">

        <div>
            <table class="table align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="name">No.</th>
                        <th scope="col" class="sort" data-sort="budget">Name</th>
                        <th scope="col" class="sort" data-sort="budget">SKU</th>
                        <th scope="col" class="sort" data-sort="budget">Voucher</th>
                        <th scope="col" class="sort" data-sort="budget">Price</th>
                        <th scope="col" class="sort" data-sort="budget">PUBLISH</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                  @foreach($package->variants as $variant)
                    <tr>
                        <th scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                </div>
                            </div>
                        </th>
                        <td>
                            {{ $variant->name }}
                        </td>

                        <td>
                            {{ $variant->sku }}
                        </td>

                        <td>
                            @foreach($variant->vouchers as $voucher)
                              <div>
                                {{$voucher->quantity}} <b>x</b> {{$voucher->type->name}} ({{ $voucher->prefix}})
                              </div>
                            @endforeach
                        </td>

                        <td>
                            @if($variant->price > $variant->sell)
                              <small><del>{{ $variant->price }}</del></small> {{$variant->sell}}
                            @endif

                        </td>

                        <td>
                            {{ $variant->status }}
                        </td>

                        <td class="text-left">
                            <div class="dropdown float-right">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('edit.variant', [$package, $variant]) }}">View / Edit</a>
                                    <!--<a class="dropdown-item" href="#">View</a>
                                    <a class="dropdown-item" href="#">Something else here</a>-->
                                </div>

                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>

              {{-- $package->links() --}}

        </div>

</div>

    </div>
