@extends('layouts.app', ['titlePage' => 'New Variant'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">
      <div class="col-xl-9 order-xl-1">
        <div class="card-body">


            <form action="{{ route('save.variant', $package) }}" method="post">
              @csrf

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Name <small class="text-danger">required</small></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Variant Name" value="{{ old('name') }}">
                    @error('name')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="name">SKU <small class="text-danger">required</small></label>
                    <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter Variant sku" value="{{old('sku') ? old('sku') : $package->sku.'-'}}">
                    @error('sku')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>


                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Remark</label>
                    <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark') }}</textarea>
                    @error('description')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>


                <div class="col-12">
                  <fieldset>
                    <legend>Voucher</legend>
                    @foreach ($types as $key => $type)
                    <div class="row">
                      <div class="col-4">
                        {{$type->name}}
                        <input name="voucherRes[{{ $key }}][package_id]" id="voucherpackage{{$key}}" type="hidden" value="{{ $package->id }}">
                        <input name="voucherRes[{{ $key }}][voucher_type_id]" id="vouchertype{{$key}}" type="hidden" value="{{ $type->id }}">
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                        <input class="form-control"  min="0" data-key="{{$key}}" id="voucherquantity{{$key}}" name="voucherRes[{{ $key }}][quantity]" type="number" value="{{old('voucherRes.'.$key.'.quantity', 0)}}">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                        <input class="form-control"  min="0" data-key="{{$key}}" id="voucherUnit{{$key}}" name="voucherRes[{{ $key }}][prefix]" type="text" value="{{old('voucherRes.'.$key.'.text', strtoupper($type->prefix))}}">
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </fieldset>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="price">Original Price <small class="text-danger">required</small></label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="{{ old('price') }}">
                    @error('price')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="sell">Selling Price <small class="text-danger">required</small></label>
                    <input type="text" class="form-control" id="sell" name="sell" placeholder="Enter Selling Price" value="{{ old('sell') }}">
                    @error('sell')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="title">Expiry <small class="text-danger">required</small></label>
                    {!! Form::select('expiry', $vExpiry, null, array('class' => 'form-control')) !!}
                    @error('expiry')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter Stock" value="{{ old('stock') }}">
                    @error('stock')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>


                <div class="col-4">
                  <div class="form-group">
                    <label for="gemder" class="d-block">Status <small class="text-danger">required</small></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Publish" value="yes" {{(old('status') == 'yes') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Publish">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="Offline" value="no" {{(old('status') == 'no') ? 'checked' : ''}}>
                      <label class="form-check-label" for="Offline">Offline</label>
                    </div>

                    @error('status')
                    <small class="text-danger d-block">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="gemder" class="d-block">Available in Online <small class="text-danger">required</small></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="online" id="online_yes" value="yes" {{(old('online') == 'yes') ? 'checked' : ''}}>
                      <label class="form-check-label" for="online_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="online" id="online_no" value="no" {{(old('online') == 'no') ? 'checked' : ''}}>
                      <label class="form-check-label" for="online_no">No</label>
                    </div>

                    @error('online')
                    <small class="text-danger d-block">{{ $message}}</small>
                    @enderror
                  </div>
                </div>






              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              <button type="submit" name="submit" value="new" class="btn btn-primary">Submit & New Package</button>

            </form>
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection

@push('css')
<style>
.input-group-text {
  background-color: #e9ecef;
  color: #525f7f;
}

fieldset {
  border: solid 1px #cad1d7;
    padding: 1rem;
    margin-bottom: 1rem;
}

legend {
  width: auto;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}
</style>
@endpush

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
