@extends('layouts.app', ['titlePage' => 'Voucher Type'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">

            {{ Form::model($vouchertype, array('route' => array('vouchertypes.update', $vouchertype->id), 'method' => 'PUT')) }}


              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Voucher Type Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Voucher Type Name" value="{{ old('name', $vouchertype->name) }}">
                    @error('name')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="short">Short Name</label>
                    <input type="text" class="form-control" id="short" name="short" placeholder="Enter Short Name" value="{{ old('short', $vouchertype->short) }}">
                    @error('short')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="short">Default Voucher Prefix</label>
                    <input type="text" class="form-control" id="prefix" name="prefix" placeholder="Enter Voucher Prefix" value="{{ old('prefix', $vouchertype->prefix) }}">
                    @error('prefix')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="gemder" class="d-block">Status</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Publish" value="yes" {{($vouchertype->status == 'yes') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Publish">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Offline" value="no"  {{($vouchertype->status == 'no') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Offline">Offline</label>
                    </div>

                    @error('status')
                    <small class="text-danger d-block">{{ $message}}</small>
                    @enderror
                  </div>
                </div>






              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              <button type="submit" name="submit" value="new" class="btn btn-primary">Submit & New Product</button>


            {{ Form::close() }}
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection
