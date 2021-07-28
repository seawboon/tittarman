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
                      {{-- <li>Vouchers</li> --}}
                      <li>Treatment Fee</li>
                      {{-- <li>Memo</li>
                      <li>My Voucher</li> --}}
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
                                  <td class="w-15">
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
                            <option value="">Choose Package</option>
                          </select>
                        </div>

                        <div id="voucher-details"></div>
                        <button class="btn-sm btn-warning mt-2" id="chk-code">Check Cobe Availability <div class="loader"></div></button>
                        <span id="hidden-chkbox"></span>

                      </div>

                      <div for="Treatment Fee">
                        <div class="row">
                          <div class="col-12">

                            <div class="form-group">
                              <label>Treatment Fee (RM)</label>
                              <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', 0) }}" {{$permit['text']}} readonly />
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group">
                              <label>Discount (RM)</label>
                              <input type="text" class="form-control productdiscount" name="treat[discount]" value="{{ old('treat.discount', 0) }}" />
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group">
                              <label>Total</label>
                              <input type="text" class="form-control treatmentfinal" name="treat[treat_final]" value="0" readonly />
                            </div>
                          </div>
                        </div>
                      </div>
                      {{--<div for="Next Appointment">
                          <p>d ut ornare non, volutpat vel tortor. InLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis urna gravida mollis.t in malesuada odio venenatis.</p>
                      </div>
                       <div for="My voucher">
                        <div class="row">
                          <div class="col-4">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#voucherModal">
                              My Vouchers
                            </button>
                            <div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                   <div class="modal-body">
                                     <div class="row newVouchers">
                                     </div>
                                     <div class="row">
                                       @if(count($patient->vouchers))
                                       @foreach($patient->vouchers as $voucher)
                                        @if($voucher->state == 'enable')
                                         <div class="col-3">
                                           <span class="code-{{$loop->iteration}} mr-2">{{ $voucher->code }}</span>
                                           <span class="copyCode border-0 bg-transparent" data-vcode="{{ $voucher->code }}"><i class="ni ni-single-copy-04"></i></span>
                                         </div>
                                         @endif
                                       @endforeach
                                       @endif
                                     </div>

                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                     </button>
                                   </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-8">
                            <div class="form-group mb-0">
                              <input type="text" class="form-control productdiscountcode" name="treat[discount_code]" placeholder="voucher code" value="{{ old('treat.discount_code') }}" />
                            </div>
                          </div>



                        </div>
                      </div> --}}
                  </div>
              </div>

              <div class="products">
                <div class="mt-3">

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
                        <td  class="">
                          <div class="form-group">
                            <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', 0) }}" readonly />
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


  $('[class*=product], .treat-fee, .productdiscount').change(function(){
    getvalues();
  });


});


@include('payment.js')
</script>
@endpush
