@extends('layouts.app', ['titlePage' => __('New Role')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">

          </div>

        <div class="col-xl-8 order-xl-1">

          {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Name:</strong>
                      {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <strong>Permission:</strong>
                      <br/>
                      @foreach($permission as $value)
                          <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                          {{ $value->name }}</label>
                      <br/>
                      @endforeach
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
