@extends('layouts.app', ['titlePage' => 'New Product'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">

            {{--<form action="{{ route('methods.update', ($method) ) }}" method="PUT">--}}
            {{ Form::model($method, array('route' => array('methods.update', $method->id), 'method' => 'PUT')) }}


              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="name">Payment Method Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" value="{{ old('name', $method->name) }}">
                    @error('name')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="gemder" class="d-block">Status</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Publish" value="yes" {{($method->status == 'yes') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Publish">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Offline" value="no"  {{($method->status == 'no') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Offline">Offline</label>
                    </div>

                    @error('status')
                    <small class="text-danger d-block">{{ $message}}</small>
                    @enderror
                  </div>
                </div>






              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              <button type="submit" name="submit" value="new" class="btn btn-primary">Submit & New Payment Method</button>


            {{ Form::close() }}
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection
