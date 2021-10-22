@extends('layouts.app', ['titlePage' => 'PAYMENT DETAIL: '. $patient->fullname])

@section('content')
    <div class="header bg-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">


        <div class="col-xl-2 order-xl-2">
        </div>

      <div class="col-xl-10 order-xl-1">
        <div class="card-body">
          @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif

            <form action="{{ route('payment.store', $patient)}}" method="post">
              @csrf
              @php
                $permit['text'] = '';
                $permit['class'] = '';
                if(auth()->user()->cannot('master-edit')) {
                  $permit['text'] = 'readonly';
                  $permit['class'] = 'invisible h-0';
                }
              @endphp



              <div class="row {{$permit['class']}}"></div>



              <h3>Payment</h3>

              <div id="PaymentTabs">
                  <ul class="resp-tabs-list ver_1">
                      <li>Products</li>
                      <li>Voucher Package</li>
                  </ul>
                  <div class="resp-tabs-container ver_1">
                      <div for="Products">
                        <div class="table-responsive products">
                          <div>
                            <table class="table align-items-center">
                              <thead class="thead-light">
                                  <tr>
                                      <th scope="col" class="sort" data-sort="budget">Product Name</th>
                                      <th scope="col" class="sort" data-sort="status">Price (RM)</th>
                                      <th scope="col" class="sort" data-sort="branch">Unit</th>
                                      <th scope="col">Total</th>
                                  </tr>
                              </thead>
                              <tbody class="list">
                                @foreach($products->where('type','!=', 'voucher') as $key => $product)
                                <tr>
                                  <td>
                                    <input type="hidden" name="product[{{ $key }}][product_id]" value="{{$product->id}}" />
                                    <input type="hidden" name="product[{{ $key }}][treat_id]" value="" />
                                    <input type="hidden" name="product[{{ $key }}][matter_id]" value="" />
                                    <input type="hidden" name="product[{{ $key }}][patient_id]" value="" />
                                    @if($product->id == 4)
                                      <textarea class="form-control" name="product[{{ $key }}][remarks]" rows="1" placeholder="Enter Others">{{ old('product.'.$key.'.remarks') }}</textarea>
                                    @else
                                      <input type="hidden" name="product[{{ $key }}][remarks]" value="" />
                                      {{ $product->name }}
                                    @endif
                                  </td>
                                  <td class="w-25">
                                    <div class="form-group">
                                      <input type="text" class="form-control productprice" name="product[{{ $key }}][price]" value="{{ old('product.'.$key.'.price', $product->price) }}" />
                                    </div>
                                  </td>
                                  <td class="w-25">
                                    <div class="form-group">
                                    @php $pType = 'item';
                                      if($product->type == 'voucher') {
                                          $pType = 'voucher';
                                      }

                                    @endphp

                                    {!! Form::select('product['.$key.'][unit]', range(0, 10) , null, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
                                    </div>

                                  </td>
                                  <td class="w-25">
                                    <div class="form-group">
                                      <input type="text" class="form-control producttotal{{ $key }}" name="product[{{ $key }}][total]" value="0" readonly />
                                    </div>
                                  </td>
                                </tr>

                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div for="Vouchers">
                        <div class="form-group">
                          <label for="days" class="d-block">Package</label>
                          <select class="form-control w-100" name="package[id]" id="buyPackage">
                            <option value="">Choose Package</option>
                            @foreach($packages as $key => $package)
                              <option value="{{$package->id}}" @if(old('package.id') && old('package.id')==$package->id) selected @endif>{{ $package->title }}</option>
                            @endforeach
                          </select>


                        </div>

                        <div class="form-group">
                          <input type="hidden" name="variantValue" class="variantValue" value="0" />
                          <label for="days" class="d-block">Package Variants</label>
                          <select class="form-control w-100" name="package[variant][id]" id="buyVariant">
                            {{-- <option value="">Choose Package</option> --}}
                          </select>
                        </div>
                        <div id="ala-carte-details">
                          <div class="row">
                            <div class="col-12 col-md-4">
                              <label for="alacartquantity">Quantity <small class="text-danger">required</small></label>
                              {!! Form::select('alacart[quantity]', range(0, 10) , null, array('class' => 'form-control', 'id'=>'alacartquantity', 'required')) !!}
                            </div>
                            <div class="col-12 col-md-4">
                              <div class="form-group">
                                <label for="sell">Price <small class="text-danger">required</small></label>
                                <input type="text" class="form-control" id="alacartsell" name="alacart[sell]" placeholder="Enter Selling Price" value="0">
                              </div>
                            </div>
                            <div class="col-12 col-md-4">
                              <div class="form-group">
                                <label for="title">Expiry <small class="text-danger">required</small></label>
                                <select class="form-control" name="alacart[expiry]">
                                  <option value="">Please Choose</option>
                                  <option value="1">1 month</option>
                                  <option value="3">3 months</option>
                                  <option value="6">6 months</option>
                                  <option value="9">9 months</option>
                                  <option value="12">12 months</option><option value="15">15 months</option><option value="18">18 months</option><option value="21">21 months</option><option value="24">24 months</option><option value="27">27 months</option><option value="30">30 months</option><option value="33">33 months</option><option value="36">36 months</option></select>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div id="voucher-details"></div>

                        <button class="btn-sm btn-warning mt-2" id="chk-code">Check Cobe Availability</button>
                        <span id="hidden-chkbox"></span>

                      </div>
                  </div>
              </div>

              <div class="products">
                <div class="mt-3"></div>
                <div class="row pt-4">
                  <div class="col-3">
                    <div class="form-group">
                      <input type="hidden" class="treat-fee" name="treat[fee]" value="0" />
                      <input type="hidden" class="treatmentfinal" name="treat[treat_final]" value="0" />
                      <input type="hidden" name="redeem_code[0][amount]" id="redeem_code_1_amount" value="0">
                      <input type="hidden" name="redeem_code[1][amount]" id="redeem_code_2_amount" value="0">
                      {!! Form::select('promotion_id', [null=>'Promotion Redeem'] + $promotions, null, array('class' => 'form-control', 'id' => 'slt-promotion')) !!}
                      @error('salutation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <input type="text" class="form-control" name="promotion_code" placeholder="Code" value=""   />
                    </div>
                  </div>
                  <div class="col-3">
                    Promotion Applied (RM)
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <input type="text" class="form-control" name="promotion_amount" id="promo_amount" value="0" />
                    </div>
                  </div>
                </div>
                <div>
                  <table class="table align-items-center">

                    <tbody class="list">

                      <tr>
                        <td class="text-left">
                          <div class="form-group">
                            {!! Form::select('treat[method_id]', [null=>'Payment Method'] + $methods, '', array('class' => 'form-control', 'id' => 'method_id', 'required')) !!}
                            @error('treat.method_id')
                            <small class="text-danger">{{ $message}}</small>
                            @enderror
                          </div>
                        </td>
                        <td colspan="2" class="text-right">
                          Total Fees (RM)
                        </td>
                        <td class="">
                          <div class="form-group">
                            <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', 0) }}" readonly />
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="3" class="text-right">
                          Paid Amount (RM)
                        </td>
                        <td class="">
                          <div class="form-group">
                            <input type="text" class="form-control" name="treat[paid_amount]" value="{{ old('treat.paid_amount', 0) }}" />
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="4" class="text-left">
                          <label for="payment_date" class="d-block">Payment Date</label>
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                              </div>
                              <input class="flatpickr datetimepicker form-control" name="payment_date" type="text" placeholder="Date & Time" value="{{ old('payment_date') }}">
                            </div>
                            @error('payment_date')
                            <small class="text-danger">{{ $message}}</small>
                            @enderror
                          </div>
                        </td>

                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>

              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

            </form>
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection

@push('css')
<style>
.datepicker table tr td.today,  .datepicker table tr td.today:hover {
  background-color: #ccc;
}

.datetimepicker {
  background-color: #fff !important;
}

.h-0 {
  height: 0;
}

hr.invisible {
  display: none;
}

.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}

[class*="pkg-"]{
  display: none;
}

#chk-code {
  display: none;
}

.duplicate {
    border: 1px solid red;
    color: red;
}

.available {
    border: 1px solid #c3e6cb;
}

#hchkbox {
  opacity: 0;
  width: 1px;
  height: 1px;
}

.loader {
  display: none;
  border-width: .2em;
  border: solid #fbc202; /* Light grey */
  border-top: solid transparent; /* Blue */
  border-radius: 50%;
  width: 1rem;
  height: 1rem;
  animation: spin 0.75s linear infinite;
  vertical-align: text-bottom;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link href="{{ asset('css/easy-responsive-tabs.css') }}" rel="stylesheet" />
@endpush

@push('js')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('js/easyResponsiveTabs.js') }}"></script>
<script>
$(document).ready(function() {

  $('#PaymentTabs').easyResponsiveTabs({
      type: 'vertical',
      width: 'auto',
      fit: true,
      tabidentify: 'ver_1', // The tab groups identifier
      activetab_bg: '#fff', // background color for active tabs in this group
      inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
      active_border_color: '#c1c1c1', // border color for active tabs heads in this group
      active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
  });

    $(document).on('click', '.copyCode', function(){
      var tisCode = $(this).data('vcode');
      $('.productdiscountcode').val(tisCode);
      $("#voucherModal").modal("hide");
    });
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
      enableTime: true,
      altInput: true,
      altFormat: "d M Y H:i",
      dateFormat: "Y-m-d H:i",
      maxDate: new Date().fp_incr(1),
      minTime: "10:00",
      maxTime: "18:00",
    });

  $('.treat-fee').on('change blur',function(){
      if($(this).val().trim().length === 0){
        $(this).val({{ old('fee', 0) }});
      }
    });

  getvalues();


  $('[class*=product], .treat-fee, .productdiscount, #alacartsell').change(function(){
    getvalues();
  });

  $('#slt-promotion').on('change',function(e) {
    var promo_id = e.target.value;
    getPromotion(promo_id);
  });

  function getPromotion(promo_id){

    $.ajax({
      url:"{{ route('getPromo') }}",
      type:"POST",
      data: {
      promo_id: promo_id
      },
      success:function (data) {
        //console.log(data.promotion.action.config);
        if(data.promotion != null) {
          if(data.promotion.type == 'coupon') {
            $('#promo_amount').val(data.promotion.action.config.amount);
          } else {
            $('#promo_amount').val(0);
          }

        } else {
          $('#promo_amount').val(0);
        }

        getvalues();

      }
    })
  };


});


@include('payment.js')
</script>
@endpush
