@extends('layouts.app', ['titlePage' => 'Payment DETAIL: '. $payment->patient->fullname])

@section('content')
    <div class="header bg-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">


        <div class="col-xl-4 order-xl-2">
        </div>

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">
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
                                  <input type="hidden" name="product[{{ $key }}][treat_id]" value="{{$payment->treat->id}}" />
                                  <input type="hidden" name="product[{{ $key }}][matter_id]" value="{{$payment->matter->id}}" />
                                  <input type="hidden" name="product[{{ $key }}][patient_id]" value="{{$payment->patient->id}}" />
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
                                  @if($payment->products->isNotEmpty())
                                  {!! Form::select('product['.$key.'][unit]', range(0, 10) , $payment->products[$key]->unit, array('class' => 'form-control productunit'.$key.'')) !!}
                                  @else
                                  {!! Form::select('product['.$key.'][unit]', range(0, 10) , null, array('class' => 'form-control productunit'.$key.'')) !!}
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

                              <tr>
                                <td>
                                  Treatment Fee (RM)
                                </td>
                                <td class="w-25">
                                  <div class="form-group mb-0">
                                    <small>&nbsp;</small>
                                    <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', $payment->treat->fee) }}" {{$permit['text']}} readonly />
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
                                <td colspan="2">

                                </td>
                                <td class="w-15">
                                  <div class="form-group mb-0">
                                    <input type="text" class="form-control productdiscountcode" name="treat[discount_code]" placeholder="voucher code" value="{{ old('treat.discount_code', $payment->discount_code) }}" />
                                  </div>
                                </td>
                                <td class="w-25">

                                </td>
                              </tr>

                              {{--<tr>
                                <td colspan="3" class="text-right">
                                  Treatment Fee (RM)
                                </td>
                                <td class="">
                                  <div class="form-group">
                                    <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', $payment->treat->fee) }}" {{$permit['text']}} readonly />
                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="3" class="text-right">
                                  Discount (RM)
                                  <div class="form-group">
                                    <input type="text" class="form-control productdiscountcode w-auto ml-auto" name="treat[discount_code]" placeholder="voucher code" value="{{ old('treat.discount_code', $payment->discount_code) }}" />
                                  </div>
                                </td>
                                <td class="">
                                  <div class="form-group">
                                    <input type="text" class="form-control productdiscount" name="treat[discount]" value="{{ old('treat.discount', $payment->discount) }}" />
                                  </div>
                                </td>
                              </tr>
                              --}}
                              <tr>
                                <td colspan="3" class="text-right">
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

              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>
              <button type="submit" name="submit" value="new-appointment" class="btn btn-primary">Submit & Make Appointment</button>

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
