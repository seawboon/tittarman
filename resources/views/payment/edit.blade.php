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
                      <li>Treatment Fee</li>
                      <li>My Voucher</li>
                      @if($payment->treat)
                      <li>Memo From Therapist</li>
                      <li>Appointment</li>
                      @endif

                  </ul>
                  <div class="resp-tabs-container ver_1">
                      <div for="Products">
                        <table class="table align-items-center">
                          <thead class="thead-light">
                            <th scope="col" class="sort" data-sort="budget">Product Name</th>
                            <th scope="col" class="sort" data-sort="status">Price (RM)</th>
                            <th scope="col" class="sort" data-sort="branch">Unit</th>
                            <th scope="col">Total</th>
                          </thead>
                          <tbody class="list">
                            @foreach($products->where('type','!=', 'voucher') as $key => $product)
                            <tr>
                              <td>
                                <input type="hidden" name="product[{{ $key }}][product_id]" value="{{$product->id}}" />
                                <input type="hidden" name="product[{{ $key }}][treat_id]" value="{{$payment->treat->id ?? ''}}" />
                                <input type="hidden" name="product[{{ $key }}][matter_id]" value="{{$payment->matter->id ?? ''}}" />
                                <input type="hidden" name="product[{{ $key }}][patient_id]" value="{{$payment->patient->id ?? ''}}" />
                                @if($product->id == 4)
                                  <textarea class="form-control" name="product[{{ $key }}][remarks]" rows="1" placeholder="Enter Others">{{ old('product.'.$key.'.remarks') }}</textarea>
                                @else
                                  <input type="hidden" name="product[{{ $key }}][remarks]" value="" />
                                  {{ $product->name }}
                                @endif
                              </td>
                              <td class="w-25">
                                <div class="form-group">
                                  @if($payment->products->isNotEmpty())
                                  <input type="text" class="form-control productprice" name="product[{{ $key }}][price]" value="{{ old('product.'.$key.'.price', $payment->products[$key]->price) }}" />
                                  @else
                                  <input type="text" class="form-control productprice" name="product[{{ $key }}][price]" value="{{ old('product.'.$key.'.price', $product->price) }}" />
                                  @endif
                                </div>
                              </td>
                              <td class="w-15">
                                <div class="form-group">
                                  @php $pType = 'item';
                                    if($product->type == 'voucher') {
                                        $pType = 'voucher';
                                    }

                                  @endphp
                                @if($payment->products->isNotEmpty())
                                    {!! Form::select('product['.$key.'][unit]', range(0, 10) , $payment->products[$key]->unit, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
                                @else
                                  {!! Form::select('product['.$key.'][unit]', range(0, 10) , null, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
                                @endif
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

                      <div for="Vouchers">
                        <div class="form-group">
                        <select class="form-control w-100 pkgSEL" name="nla">
                          <option value="">Choose Package</option>
                          @foreach($packages as $key => $package)
                            <option value="{{$package->id}}">{{ $package->title }}</option>
                          @endforeach
                        </select>
                        </div>

                        <div id="packageContent">
                          @foreach($packages as $key => $package)
                          <div class="pkg-{{$package->id}}" id="{{$package->slug}}">
                            {{ $package->title }}: <del>RM {{ $package->total }}</del> RM {{ $package->sell }}<br />
                            @foreach($package->products as $key => $product)
                              {{$product->product->name}} * {{$product->unit}}
                              @if(!$loop->last)<br />@endif
                            @endforeach
                          </div>
                          @endforeach
                        </div>
                      </div>

                      <div for="Treatment Fee">
                        <div class="row">
                          <div class="col-12">

                            <div class="form-group">
                              <label>Treatment Fee (RM)</label>
                              <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', $payment->treatment_fee) }}" {{$permit['text']}} readonly />
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group">
                              <label>Discount (RM)</label>
                              <input type="text" class="form-control productdiscount" name="treat[discount]" value="{{ old('treat.discount', $payment->discount) }}" />
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

                      <div for="My voucher">
                        <select class="voucherselect w-100" name="treat[discount_code]">
                          <option value="">voucher code</option>
                          @foreach($voucherEd as $owner)
                          <optgroup label="{{$owner->id}}. {{$owner->fullname}}">
                            @foreach($owner->AvailabelVoucher as $voucher)
                            <option value="{{$voucher->code}}" {{$payment->discount_code==$voucher->code ? 'selected="selected"':''}}>{{$voucher->code}}</option>
                            @endforeach
                          </optgroup>
                          @endforeach
                        </select>
                        @if($payment->discount_code!='')
                        <span class="text-white bg-warning py-1 px-2 mt-1 d-block">Claimed: {{$payment->discount_code}}</span>
                        @endif
                      </div>

                      @if($payment->treat)
                      <div for="Memo">
                          <p>{{ $payment->treat->memo}}</p>
                      </div>
                      <div for="Next Appointment">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="days" class="d-block">Next Treatment</label>
                              {!! Form::select('treat[days]', [null=>'Please Select'] + $days, $payment->treat->days, array('class' => 'form-control', 'id' => 'days','readonly' => true)) !!}
                              @error('treat.days')
                              <small class="text-danger">{{ $message}}</small>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif

                  </div>
              </div>

              <div class="clearfix pt-4" style="clear:both">
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
              </div>

              <div class="clearfix pt-4" style="clear:both">
                <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>
                @if($payment->treat)
                <button type="submit" name="submit" value="new-appointment" class="btn btn-primary">Submit & Make Appointment</button>
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

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link href="{{ asset('css/easy-responsive-tabs.css') }}" rel="stylesheet" />
@endpush

@push('js')


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/easyResponsiveTabs.js') }}"></script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">

 <div class="modal-body">
   <img class="modalimage w-100" src="" />
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
 </div>
</div>
</div>
</div>
<script>
$(function(){
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(recipient);
    modal.find('.modalimage').attr('src', recipient);
  });
});
</script>

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

  $('[class*=product], .treat-fee, .productdiscount').change(function(){
    getvalues();
  });

  function getvalues(){
    $('[class*=productprice]').each(function (key, value) {
       var price = $(this).val();
       var unit = $('.productunit'+key).val();
       var total = price*unit;
       var fee = $('.treat-fee').val();
       var discount = $('.productdiscount').val();
       $('.producttotal'+key).val(total);

       var productsum = parseFloat(fee - discount);

       $('.treatmentfinal').val(productsum);

       $('[class*=producttotal]').each(function () {
          productsum += parseFloat($(this).val());
       });

       $('.productsum').val(productsum);

    });

  };

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

  $('.btn-before').click(function(){
    var html = $('.clone.before').html();
    $('.increment.before').after(html);
  });

  $('.btn-after').click(function(){
    var html = $('.clone.after').html();
    $('.increment.after').after(html);
  });

  $('body').on('click', '.btn-danger', function(){
    $(this).parents(".control-group").remove();
  });

  $("body").on('change', '.custom-file input', function (e) {
    if (e.target.files.length) {
      $(this).next('.custom-file-label').html(e.target.files[0].name);
    }
  });

});

$('.pkgSEL').change(function(){
  var pkgName = ".pkg-"+$(this).val();
  $('[class*="pkg-"]').hide();
  $(pkgName).show();
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
@endpush
