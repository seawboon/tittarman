@extends('layouts.app', ['titlePage' => __(' Role Management')])

@section('content')

    <!-- Top navbar -->
        <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
<div class="container-fluid">

</div>
</div>
<div class="container-fluid mt--7">
<div class="row">
    <div class="col">
        <div class="">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Roles</h3>
                    </div>
                    <div class="col-4 text-right">
                        @can('role-create')
                        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Create New Role</a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="col-12">
                                    </div>

            <div class="table-responsive" style="overflow-x:unset">
                <table class="table align-items-center" >
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $role->name }}</td>

                              <td class="text-right">
                                  <div class="dropdown">
                                      <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fas fa-ellipsis-v"></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('roles.show',$role->id) }}">Show</a>
                                            @can('role-edit')<a class="dropdown-item" href="{{ route('roles.edit',$role->id) }}">Edit</a>@endcan
                                            <a href="#" class="dropdown-item" onclick="event.preventDefault();
                                            document.getElementById('role-del').submit();">
                                                Delete
                                                {!! Form::open(['method' => 'DELETE', 'name' => 'role-del','route' => ['roles.destroy', $role->id],'style'=>'display:none']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </a>


                                      </div>
                                  </div>
                              </td>
                          </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

 </div>


@endsection
