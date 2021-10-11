@extends('layouts.app', ['titlePage' => 'Payment DETAIL: '. $payment->patient->fullname])

@section('content')
    <div class="header bg-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">


        <div class="col-xl-4 order-xl-2">
        </div>

      <div class="col-xl-8 order-xl-1">
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

              <div class="table-responsive products">
                <div>
                  <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="budget">Product Name</th>
                            <th scope="col" class="sort" data-sort="status">Price (RM)</th>
                            <th scope="col" class="sort" data-sort="branch">Unit</th>
                            <th scope="col">Total</th>
                            <tbody class="list">
                              @foreach($products as $key => $product)
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
                                    @if($product->type == 'voucher')
                                      @php
                                      $maxx=10;
                                      if($payment->products[$key]->unit > 0) {
                                        $maxx = $payment->products[$key]->unit;
                                      }

                                      @endphp
                                      {!! Form::select('product['.$key.'][unit]', array_combine(range($payment->products[$key]->unit,$maxx),range($payment->products[$key]->unit,$maxx)) , $payment->products[$key]->unit, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
                                    @else
                                      {!! Form::select('product['.$key.'][unit]', range(0, 10) , $payment->products[$key]->unit, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
                                    @endif
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

                              @if($product->type == 'voucher')
                               @if(isset($payment->products[$key]))
                                    @if($payment->products[$key]->unit > 0)
                                      <tr>
                                        <td colspan="4">
                                          <div class="row">
                                            @foreach($payment->vouchers as $ckey => $voucher)
                                            <div class="col-3">
                                              {{$loop->iteration}}. {{ $voucher->code}}
                                            </div>
                                            @endforeach
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="white-space:initial">
                                          <div class="row typeVoucherRow">
                                            <div class="col-12">
                                              Remarks
                                            </div>
                                          </div>
                                        </td>
                                        <td colspan="3" style="white-space:initial">
                                          <div class="row typeVoucherRow">
                                            <textarea class="form-control" id="notes" name="product[{{ $key }}][remarks]" rows="2" placeholder="Enter Remarks">{{ old('product.'.$key.'.remark', $payment->products[$key]->remarks) }}</textarea>
                                          </div>
                                        </td>

                                      </tr>
                                    @else
                                    <tr class="typeVoucher d-none">
                                        <td colspan="4" style="white-space:initial">
                                          <div class="row typeVoucherRow">
                                            <div class="col-12">
                                              <select class="js-example-basic-multiple w-100" name="voucher[][code]" multiple="multiple">
                                                @foreach($vouchers as $voucher)
                                                 @if($voucher->state == 'enable' && $voucher->payment_id == null)
                                                  <option value="{{$voucher->code}}">{{$voucher->code}}</option>
                                                 @endif
                                                @endforeach
                                              </select>
                                            </div>

                                            <div class="voucherHidden"></div>
                                          </div>
                                        </td>

                                      </tr>
                                      <tr class="typeVoucher d-none">
                                        <td style="white-space:initial">
                                          <div class="row typeVoucherRow">
                                            <div class="col-12">
                                              Remarks
                                            </div>
                                          </div>
                                        </td>
                                        <td colspan="3" style="white-space:initial">
                                          <div class="row typeVoucherRow">
                                            <textarea class="form-control" id="notes" name="product[{{ $key }}][remarks]" rows="2" placeholder="Enter Remarks">{{ old('product.'.$key.'.remark', $product->remarks) }}</textarea>
                                          </div>
                                        </td>

                                      </tr>
                                    @endif
                                @else
                                <tr class="typeVoucher d-none">
                                    <td colspan="4" style="white-space:initial">
                                      <div class="row typeVoucherRow">
                                        <div class="col-12">
                                          <select class="js-example-basic-multiple w-100" name="voucher[][code]" multiple="multiple">
                                            @foreach($vouchers as $voucher)
                                             @if($voucher->state == 'enable' && $voucher->payment_id == null)
                                              <option value="{{$voucher->code}}">{{$voucher->code}}</option>
                                             @endif
                                            @endforeach
                                          </select>
                                        </div>

                                        <div class="voucherHidden"></div>
                                      </div>
                                    </td>

                                  </tr>
                              @endif


                                <script>
                                var VproductID = {{$product->id}};
                                </script>
                              @endif

                              @endforeach

                              <tr>
                                <td>
                                  Treatment Fee (RM)
                                </td>
                                <td class="w-25">
                                  <div class="form-group mb-0">
                                    <small>&nbsp;</small>
                                    <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', $payment->treatment_fee) }}" {{$permit['text']}} readonly />
                                  </div>
                                </td>
                                <td class="w-15">
                                  <div class="form-group mb-0">
                                    <small>Discount (RM)</small>
                                    <input type="text" class="form-control productdiscount" name="treat[discount]" value="{{ old('treat.discount', $payment->discount) }}" />
                                  </div>
                                </td>
                                <td class="w-25">
                                  <div class="form-group mb-0">
                                    <small>&nbsp;</small>
                                    <input type="text" class="form-control treatmentfinal" name="treat[treat_final]" value="0" readonly />
                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td  class="text-right">

                                  {{-- <button type="button" class="btn btn-info btn-sm {{$payment->discount_code!='' ? 'd-none':''}}" data-toggle="modal" data-target="#voucherModal">
                                    My Vouchers
                                  </button>

                                  <div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                         <div class="modal-body">
                                           <div class="row newVouchers">
                                           </div>
                                           <div class="row">
                                               @foreach($vouchers as $voucher)
                                                @if($voucher->state == 'enable' && $voucher->payment_id!=null)
                                                 <div class="col-3">
                                                   <span class="code-{{$loop->iteration}} mr-2 {{ $voucher->patient_id == $payment->patient->id ? 'text-white bg-primary px-1':'' }}" data-toggle="tooltip" data-placement="bottom" title="{{$voucher->patient->id}}. {{$voucher->patient->salutation}} {{$voucher->patient->fullname}}">{{ $voucher->code }}</span>
                                                   <span class="copyCode border-0 bg-transparent" data-vcode="{{ $voucher->code }}"><i class="ni ni-single-copy-04"></i></span>
                                                 </div>
                                                 @endif
                                               @endforeach
                                           </div>

                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                           </button>
                                         </div>
                                      </div>
                                    </div>
                                  </div>--}}

                                </td>

                                <td colspan="2">
                                  <!--<div class="form-group mb-0">
                                    <input type="text" class="form-control productdiscountcode" name="treat[discount_code]" placeholder="voucher code" value="{{ old('treat.discount_code', $payment->discount_code) }}" {{ $payment->discount_code!='' ? 'readonly':'' }}/>
                                  </div>-->
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
                                </td>
                                <td class="w-25"></td>
                              </tr>

                              <tr>
                                <td class="text-left">
                                  <div class="form-group">
                                    {!! Form::select('treat[method_id]', [null=>'Payment Method'] + $methods, $payment->method_id, array('class' => 'form-control', 'id' => 'method_id', 'required')) !!}
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
                                    <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', '0') }}" readonly />
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                        </tr>
                    </thead>
                  </table>
                </div>
              </div>

              @if($payment->treat)
              <h3>Appointment</h3>
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

              <h3>Memo From Therapist</h3>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    {{ $payment->treat->memo}}
                  </div>
                </div>
              </div>
              @endif

              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>
              @if($payment->treat)
              <button type="submit" name="submit" value="new-appointment" class="btn btn-primary">Submit & Make Appointment</button>
              @endif

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

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
@endpush
