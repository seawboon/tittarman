@extends('layouts.app', ['titlePage' => 'New Product'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">

            {{--<form action="{{ route('products.update', ($product) ) }}" method="PUT">--}}
            {{ Form::model($package, array('route' => array('packages.update', $package->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
            @csrf

              <div class="row">


                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Enter Package Title" value="{{ old('title', $package->title) }}">
                      @error('title')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>



                  <div class="col-12">
                    <div class="form-group">
                      <label for="address">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description">{{ old('description', $package->description) }}</textarea>
                      @error('description')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <label for="publish_date_start" class="d-block">Publish Start On <small class="text-danger">required</small></label>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="flatpickr datetimepicker form-control" name="publish_date_start" type="text" placeholder="Date & Time" value="{{ old('publish_date_start', $package->publish_date_start) }}">
                      </div>
                      @error('publish_date_start')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <label for="publish_date_end" class="d-block">Publish End On <small class="text-danger">required</small></label>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="flatpickr datetimepicker form-control" name="publish_date_end" type="text" placeholder="Date & Time" value="{{ old('publish_date_end', $package->publish_date_end) }}">
                      </div>
                      @error('publish_date_end')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group control-group increment after">
                      <label>Package Banner</label>
                      <div class="custom-file after">
                          <input type="file" class="custom-file-input" name="filename" lang="en">
                          <label class="custom-file-label" for="customFileLang">Select file</label>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <fieldset class="border p-2 mb-4">
                      <legend class="w-auto px-2">Products</legend>
                      @foreach ($products as $key => $product)
                      <div class="form-check form-check">
                        <div class="row">
                          <div class="col-4">
                            {{--
                              <input class="form-check-input" type="checkbox" id="product{{$key}}" name="productRes[{{ $key }}][product_id]" value="{{ $product['id'] }}" {{old('productRes.'.$key.'.product_id') ? 'checked' : ''}}>
                            --}}
                            <input name="productRes[{{ $key }}][product_id]" id="product{{$key}}" type="hidden" value="{{ $product['id'] }}">
                            <label class="form-check-label" for="product{{$key}}">{{ $product['name'] }}</label>
                          </div>

                          @php
                            $ppp = $packageProducts->where('product_id', $product['id']);
                            $pUnit = 0;
                            $ppTotal = 0;
                            if(!$ppp->isEmpty()) {
                              $pUnit = $ppp[0]->unit;
                              $ppTotal = $ppp[0]->total;
                            }
                          @endphp

                          <div class="col-2">
                            RM {{ $product['price'] }}
                            <input name="productRes[{{ $key }}][price]" id="productPrice{{ $key }}" type="hidden" value="{{ $product['price'] }}">
                          </div>
                          <div class="col-2">
                            <input class="form-control unitChg"  min="0" data-key="{{$key}}" id="productUnit{{$key}}" name="productRes[{{ $key }}][unit]" type="number" value="{{old('productRes.'.$key.'.unit', $pUnit)}}">
                          </div>
                          <div class="col-4">
                            <input class="form-control cProductTotal"  min="0" id="productTotal{{$key}}" name="productTotal[{{$key}}]" type="number" value="{{old('productTotal.'.$key, $ppTotal)}}" readonly>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      <hr />
                      <div class="row">
                        <div class="col-8 text-right">
                          Sum
                        </div>

                        <div class="col-4">
                          <input class="form-control"  min="0" id="productsSum" name="total" type="number" value="{{old('total', $package->total)}}" readonly>
                        </div>

                      </div>

                      @error('productRes.*.product_id')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </fieldset>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="address">Selling Price</label>
                      <input type="text" class="form-control" id="sell" name="sell" rows="3" placeholder="Enter Price" value="{{ old('sell', $package->sell) }}">
                      @error('sell')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="type" class="d-block">Discount(%)</label>
                      <input type="text" class="form-control" id="percentage" name="percentage" rows="3" placeholder="Enter Discount" value="{{ old('percentage', $package->percentage) }}">
                      @error('percentage')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="gemder" class="d-block">Status</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="Publish" value="yes" {{(old('status', $package->status) == 'yes') ? 'checked' : ''}}>
                        <label class="form-check-label" for="Publish">Publish</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="Offline" value="no" {{(old('status', $package->status) == 'no') ? 'checked' : ''}}>
                        <label class="form-check-label" for="Offline">Offline</label>
                      </div>

                      @error('status')
                      <small class="text-danger d-block">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>






                </div>




              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              <button type="submit" name="submit" value="new" class="btn btn-primary">Submit & New Package</button>


            {{ Form::close() }}
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection

@push('js')
<style>
.datepicker table tr td.today,  .datepicker table tr td.today:hover {
  background-color: #ccc;
}

.datetimepicker {
  background-color: #fff !important;
}


</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
$(document).ready(function() {
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
    enableTime: true,
    altInput: true,
    altFormat: "F j, Y H:i",
    dateFormat: "Y-m-d H:i",
    defaultHour: {{date('H')}},
    defaultMinute: {{date('i')}}
  });

$('.unitChg').change( function() {
  var key = $(this).data("key");
  var keyPrice = $('#productPrice'+key).val();
  var keyUnit = $(this).val();
  $('#productTotal'+key).val(keyUnit*keyPrice);
  sumProducts();
});

$('#sell').change( function() {
  calcDiscount()
});

$('#percentage').change( function() {
  calcSum()
});

function sumProducts() {
  var totalPoints = 0;
  $('.cProductTotal').each(function(){
          totalPoints = parseFloat($(this).val()) + totalPoints;
  });
  //alert(totalPoints);
  $('#productsSum').val(totalPoints);
  calcDiscount()
}

function calcDiscount() {
  var selling = $('#sell').val();
  var actualPrice = $('#productsSum').val();
  var percentage = (((actualPrice-selling) / actualPrice) * 100);
  percentage = percentage.toFixed(2);
  $('#percentage').val(percentage);
}

function calcSum() {
  var percentage = $('#percentage').val();
  var actualPrice = $('#productsSum').val();
  var sumsum = ((100-percentage)/100)*actualPrice;
  $('#sell').val(sumsum);
}

$("body").on('change', '.custom-file input', function (e) {
  if (e.target.files.length) {
    $(this).next('.custom-file-label').html(e.target.files[0].name);
  }
});

});
</script>
@endpush
