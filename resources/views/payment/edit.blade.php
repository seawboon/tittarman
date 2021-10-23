@extends('layouts.app', ['titlePage' => 'Payment DETAIL: '. $payment->patient->fullname])

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

            <form action="{{ route('payment.update', $payment)}}" method="post">
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
                      <li>Treatment Fee / My Voucher</li>
                      @if($payment->treat)
                      <li>Memo From Therapist</li>
                      {{-- <li>Appointment</li> --}}
                      @endif

                  </ul>
                  @include('payment.includes.edit.tabs')
              </div>

              <div class="clearfix pt-4" style="clear:both">
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      {!! Form::select('promotion_id', [null=>'Promotion Redeem'] + $promotions, $payment->discountPromotions->first() ? $payment->discountPromotions->first()->discountable_id:null, array('class' => 'form-control', 'id' => 'slt-promotion')) !!}
                      @error('salutation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <input type="text" class="form-control" name="promotion_code" placeholder="Code" value="{{$payment->discountPromotions->first() ? $payment->discountPromotions->first()->code:''}}"   />
                    </div>
                  </div>
                  <div class="col-3">
                    Promotion Applied (RM)
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <input type="text" class="form-control" name="promotion_amount" id="promo_amount" value="{{$payment->discountPromotions->first() ? $payment->discountPromotions->first()->discount_amount:0}}" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      {!! Form::select('treat[method_id]', [null=>'Payment Method'] + $methods, $payment->method_id, array('class' => 'form-control', 'id' => 'method_id', 'required')) !!}
                      @error('treat.method_id')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12 col-lg-3 text-right">
                    Total Fees (RM)
                  </div>
                  <div class="col-12 col-lg-5">
                    <div class="form-group">
                      <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', '0') }}" readonly />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-lg-5 text-right">
                    Paid History (RM)
                  </div>
                  <div class="col-12 col-lg-7">
                    @foreach($payment->collections as $collection)
                    <div class="row">
                      <div class="col-4"><small>{{Carbon\Carbon::parse($collection->created_at)->format('d M Y')}}</small></div>
                      <div class="col-4"><small>RM {{$collection->amount}}</small></div>
                      <div class="col-4"><small>{{$collection->method->name}}</small></div>
                    </div>
                    @endforeach
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-lg-5 text-right">
                    Balance (RM)
                  </div>
                  <div class="col-12 col-lg-7 balance-wrp">
                    RM {{$payment->total - $payment->collections->sum('amount')}}
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12 col-lg-5 text-right">
                    Paid Amount (RM)
                  </div>
                  <div class="col-12 col-lg-7">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <input type="text" class="form-control" name="treat[paid_amount]" value="{{ old('treat.paid_amount', 0) }}" />
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="flatpickr datetimepicker form-control" name="treat[paid_date]" type="text" placeholder="Date & Time" value="{{ old('treat.paid_date') }}">
                          </div>
                          @error('treat.paid_date')
                          <small class="text-danger">{{ $message}}</small>
                          @enderror
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>

              <div class="clearfix pt-4" style="clear:both">
                <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

                <button type="submit" name="submit" value="payment-list" class="btn btn-primary">Submit & Back Payment List</button>
                @if($payment->treat)
                {{-- <button type="submit" name="submit" value="new-appointment" class="btn btn-primary">Submit & Make Appointment</button> --}}
                @endif
              </div>


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

.select2-container {
  width: 100% !important;
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
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/easyResponsiveTabs.js') }}"></script>
<script src="{{ asset('js/payment.js') }}"></script>

<div class="modal fade" id="patient-vouchers-modal" tabindex="-1" role="dialog" aria-labelledby="patient-vouchers-modal-Label" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

       <div class="modal-body">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>

         <form action="{{ route('payment.edit', $payment)}}" method="get">
           <div class="row">
             <div class="col-12"><h4>Search Vouchers</h4></div>
             <div class="col-3"><input class="form-control form-control-sm" name="searchName" id="searchName" placeholder="by Name" type="text"></div>
             <div class="col-3"><input class="form-control form-control-sm" name="searchContact" id="searchContact" placeholder="by Contact" type="text"></div>
             <div class="col-3"><input class="form-control form-control-sm" name="searchNRIC" id="searchNRIC" placeholder="by NRIC" type="text"></div>
             <div class="col-3"><button type="submit" name="submit" class="btn btn-sm btn-primary">Search</button></div>
           </div>
         </form>
         @if($customerVouchers->isNotEmpty())
         <div class="row mt-3">
           <div class="col-12 pb-3"><h3 class="pt-2 text-success">{{$customerVouchers->first()->patient->fullname}}</h3></div>

            @foreach($customerVouchers->groupBy('voucher_type_id') as $voucherTypes)
            <div class="col-12 pb-3">
              <h4>{{$voucherTypes->first()->type->name}}</h4>
              <div class="row">
                @foreach($voucherTypes as $aVoucher)
                <div class="col-3" id="wrp-{{$aVoucher->code}}">{{$aVoucher->code}} <i class="ni ni-ungroup cp-code text-pink" data-code="{{$aVoucher->code}}" style="color:green"></i></div>
                @endforeach
              </div>
            </div>
             @endforeach
         </div>
         @endif
       </div>
    </div>
  </div>
</div>

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
        $(this).val({{ old('fee', '0') }});
      }
    });

  getvalues();

  $('[class*=product], .treat-fee, .productdiscount, #alacartsell, #promo_amount, #redeem_code_1_amount, #redeem_code_2_amount').change(function(){
    getvalues();
  });


  $('.voucher').change(function(){
    var vQuantity = $(this).val()*2;
    if(vQuantity > 0) {
      var $select = $('.js-example-basic-multiple');
      var values = $select.val();
      var valuesLength = values.length;
      if(valuesLength > vQuantity) {
        var delItems = valuesLength - vQuantity;
        values.splice(-delItems);
        $select.val(values).change();
      }

      $('.typeVoucher').addClass('d-table-row')
      vSelect(vQuantity);
      vFields(vQuantity);
    } else {
      vFields(0);
      $('.typeVoucher').addClass('d-none').removeClass('d-table-row');
    }

  });

  function vSelect(vQuantity){
    $('.js-example-basic-multiple').select2({
      maximumSelectionLength: vQuantity
    });
  }

  function vFields(vQuantity){
    var vField ='';
    for (var i = 0; i < vQuantity; i++) {
      //vField += '<div class="col-4 mb-2">';
      vField += '<input type="hidden" class="form-control" name="voucher['+i+'][product_id]" placeholder="voucher code" value="'+VproductID+'">';
      //vField += '<input type="text" class="form-control voucherCode" name="voucher['+i+'][code]" placeholder="voucher code" required>';
      //vField += '</div>';
    }

    $('.voucherHidden').html(vField);
  }

  $('.js-example-basic-multiple').on("select2:select", function (e) {

      //this returns all the selected item
      var items= $(this).val();
      //console.log(items);

      var Vmodal = $('#voucherModal .modal-body .row.newVouchers');

      if(items.length > 0) {
        var newtemp = '';
        $.each( items, function( i, val ) {
          //newtemp += '<div class="col-3"><span class="code-2 mr-2 text-info">'+val+'</span><span class="copyCode border-0 bg-transparent" data-vcode="'+val+'"><i class="ni ni-single-copy-04"></i></span></div>';


          if($(".voucherselect option[value='"+val+"']").length == 0) {
            newtemp += '<option value="'+val+'">'+val+'</option>';
          }


        });
        $('.voucherselect').prepend(newtemp);
        $('.voucherselect').trigger('change');
        //Vmodal.html(newtemp);
      } else {
        Vmodal.html('');
      }

      //Gets the last selected item
      //var lastSelectedItem = e.params.data.id;

  });

  $('.js-example-basic-multiple').on("select2:unselect", function (e) {
    $(".voucherselect option[value='"+e.params.data.id+"']").remove();
  });

  $('.voucherselect').select2();

  @if($payment->discount_code!='')
  $(".voucherselect").prop("disabled", true);
  @endif

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
