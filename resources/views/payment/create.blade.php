@extends('layouts.app', ['titlePage' => 'PAYMENT DETAIL: '. $patient->fullname])

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

                              @if($product->type == 'voucher')
                                <tr class="typeVoucher d-none">
                                  <td colspan="4">
                                    <div class="row typeVoucherRow">
                                    </div>
                                  </td>
                                </tr>

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
                                    <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', 0) }}" {{$permit['text']}} readonly />
                                  </div>
                                </td>
                                <td class="w-15">
                                  <div class="form-group mb-0">
                                    <small>Discount (RM)</small>
                                    <input type="text" class="form-control productdiscount" name="treat[discount]" value="{{ old('treat.discount', 0) }}" />
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
                                @if(count($patient->vouchers))
                                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#voucherModal">
                                    My Vouchers
                                  </button>

                                  <div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                         <div class="modal-body">

                                           <div class="row">
                                             @foreach($patient->vouchers as $voucher)
                                              @if($voucher->state == 'enable')
                                               <div class="col-3">
                                                 <span class="code-{{$loop->iteration}} mr-2">{{ $voucher->code }}</span>
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
                                  </div>
                                  @endif
                                </td>
                                <td colspan="2">
                                  <div class="form-group mb-0">
                                    <input type="text" class="form-control productdiscountcode" name="treat[discount_code]" placeholder="voucher code" value="{{ old('treat.discount_code') }}" />
                                  </div>
                                </td>
                                <td class="w-25">

                                </td>
                              </tr>

                              <tr>
                                <td colspan="3" class="text-right">
                                  Total Fees (RM)
                                </td>
                                <td class="">
                                  <div class="form-group">
                                    <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', 0) }}" readonly />
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                        </tr>
                    </thead>
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

@push('js')
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

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function() {

    $('.copyCode').click(function(){
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

  $('.voucher').change(function(){
    var vQuantity = $(this).val()*2;
    if(vQuantity > 0) {
      $('.typeVoucher').addClass('d-table-row')
      vFields(vQuantity);
    } else {
      vFields(0);
      $('.typeVoucher').addClass('d-none').removeClass('d-table-row');
    }

  });

  function vFields(vQuantity){
    var vField ='';
    for (var i = 0; i < vQuantity; i++) {
      vField += '<div class="col-4 mb-2">';
      vField += '<input type="hidden" class="form-control" name="voucher['+i+'][product_id]" placeholder="voucher code" value="'+VproductID+'">';
      vField += '<input type="text" class="form-control voucherCode" name="voucher['+i+'][code]" placeholder="voucher code" required>';
      vField += '</div>';
    }

    $('.typeVoucherRow').html(vField);
  }

  /*<input type="hidden" class="form-control" name="voucher[1][product_id]" placeholder="voucher code" value="{{$product->id}}" >
  <input type="text" class="form-control voucherCode" name="voucher[1][code]" placeholder="voucher code" required>*/

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
</script>
@endpush
