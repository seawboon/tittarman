@extends('layouts.app', ['titlePage' => __('Products')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div class="mb-2">
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Add New Product</a>
          </div>

          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">No.</th>
                            <th scope="col" class="sort" data-sort="budget">Name</th>
                            <th scope="col" class="sort" data-sort="price">Price</th>
                            <th scope="col" class="sort" data-sort="price">Type</th>
                            <th scope="col" class="sort" data-sort="status">Publish</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($products as $product)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                    </div>
                                </div>
                            </th>
                            <td>
                                {{ $product->name }}
                                <small class="d-block">{{ $product->description }}</small>
                            </td>
                            <td>
                              {{ $product->price }}
                            </td>

                            <td class="text-capitalize">
                              {{ $product->type }}
                            </td>

                            <td class="text-capitalize">
                              {{ $product->status }}
                            </td>

                            <td class="text-left">
                                <div class="dropdown float-right">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('products.edit', $product) }}">View / Edit</a>
                                        <!--<a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Something else here</a>-->
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                  {{ $products->links() }}

            </div>

</div>

        </div>

    </div>


@endsection
