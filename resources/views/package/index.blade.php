@extends('layouts.app', ['titlePage' => __('Packages')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div class="mb-2">
            <a href="{{ route('packages.create') }}" class="btn btn-sm btn-primary">Add New Package</a>
          </div>

          <div class="table-responsive">

            <div>
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">No.</th>
                            <th scope="col" class="sort" data-sort="budget">Title</th>
                            <th scope="col" class="sort" data-sort="budget">Publish Start On</th>
                            <th scope="col" class="sort" data-sort="budget">Publish End On</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                      @foreach($packages as $package)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                    </div>
                                </div>
                            </th>
                            <td>
                                {{ $package->title }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($package->publish_date_start)->format(config('app.datetime_format')) }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($package->publish_date_end)->format(config('app.datetime_format')) }}
                            </td>



                        </tr>
                        @endforeach

                    </tbody>
                </table>

                  {{ $packages->links() }}

            </div>

</div>

        </div>

    </div>


@endsection
