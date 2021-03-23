@extends('layouts.app', ['titlePage' => 'New Product'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">

            {{--<form action="{{ route('products.update', ($product) ) }}" method="PUT">--}}
            {{ Form::model($product, array('route' => array('products.update', $product->id), 'method' => 'PUT')) }}


              <div class="row">
                <div class="col-8">
                  <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" value="{{ old('name', $product->name) }}">
                    @error('name')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="name">Available in SHOP</label>
                    {!! Form::select('shop', ['no' => 'No', 'yes' => 'Yes'], $product->shop, array('class' => 'form-control', 'id' => 'shop')) !!}
                    @error('shop')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Product Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="address">Product Price</label>
                    <input type="text" class="form-control" id="price" name="price" rows="3" placeholder="Enter Price" value="{{ old('price', $product->price) }}">
                    @error('price')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="type" class="d-block">Type</label>
                    {!! Form::select('type', ['item' => 'Item', 'voucher' => 'Voucher'], $product->type, array('class' => 'form-control', 'id' => 'type')) !!}
                    @error('type')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="gemder" class="d-block">Status</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Publish" value="yes" {{($product->status == 'yes') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Publish">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Offline" value="no"  {{($product->status == 'no') ? 'checked' : ''}}>
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
