@extends('layouts.app', ['titlePage' => __('User')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">

          </div>

        <div class="col-xl-8 order-xl-1">

          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <strong>Name:</strong>
                  {{ $user->name }}
              </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <strong>Email:</strong>
                  {{ $user->email }}
              </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <strong>Roles:</strong>
                  @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                          <label class="badge badge-success">{{ $v }}</label>
                      @endforeach
                  @endif
              </div>
          </div>
          </div>


        </div>


        </div>

        </div>

    </div>


    @endsection
