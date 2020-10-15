@extends('layouts.app', ['titlePage' => __(' Treatment')])

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
                        <h3 class="mb-0">Users</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Add user</a>
                    </div>
                </div>
            </div>

            <div class="col-12"></div>

            <div class="table-responsive" style="overflow-x:unset">
                <table class="table align-items-center" >
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Roles</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                        <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $user->name }} <span class="badge badge-circle badge-floating border-white" style="background-color:{{$user->color}}; width:1rem; height:1rem">&nbsp;</span></td>
                              <td>{{ $user->email }}</td>
                              <td>
                               @if(!empty($user->getRoleNames()))
                                 @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                 @endforeach
                               @endif
                             </td>
                             {{--<td>
                                 <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>

                                 <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                  {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                  {!! Form::close() !!}
                              </td>--}}
                              <td class="text-right">
                                  <div class="dropdown">
                                      <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fas fa-ellipsis-v"></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('users.show',$user->id) }}">Show</a>
                                            @if(auth()->user()->can('role-edit') or $user->id == Auth::user()->id)
                                            <a class="dropdown-item" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                            @endif
                                            @can('role-delete')
                                            <a href="#" class="dropdown-item" onclick="event.preventDefault();
                                            document.getElementById('user-del').submit();">
                                                Delete
                                                {!! Form::open(['method' => 'DELETE', 'name' => 'user-del', 'route' => ['users.destroy', $user->id],'style'=>'display:none']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                            @endcan

                                      </div>
                                  </div>
                              </td>
                          </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>

            {{ $data->links() }}

        </div>
    </div>
</div>

 </div>


@endsection
