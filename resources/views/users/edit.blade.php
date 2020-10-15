@extends('layouts.app', ['titlePage' => __('New User')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">

          </div>

        <div class="col-xl-8 order-xl-1">

          {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Name:</strong>
                      {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Email:</strong>
                      {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Password:</strong>
                      {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Confirm Password:</strong>
                      {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                  <div id="cp2" class="input-group colorpicker colorpicker-component">
                    <input type="text" id="color" name="color" value="{{ $user->color==null ?:$randomcolor }}" class="form-control" />
                    <span class="input-group-addon"><i></i></span>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Role:</strong>
                      {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </div>
          {!! Form::close() !!}


        </div>


        </div>

        </div>

    </div>


    @endsection

    @push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <style>
      .colorpicker:before {
        display: none;
      }
      .colorpicker-element .add-on i, .colorpicker-element .input-group-addon i {
        height: 100%;
        width: 30px;
      }
    </style>
    @endpush
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>
    <script type="text/javascript">
      $('.colorpicker').colorpicker({});
    </script>
    @endpush
