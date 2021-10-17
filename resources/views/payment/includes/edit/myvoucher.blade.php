<div for="My voucher">
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label>Treatment Fee (RM)</label>
        <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', $payment->treatment_fee) }}" {{$permit['text']}} readonly />
      </div>
    </div>
  </div>

  <div class="row">
    <div  class="col-6">
      <label>Redeem Voucher 1
        <i class="fas fa-search search-voucher text-info" data-toggle="modal" data-target="#patient-vouchers-modal"></i>
        <i class="fas fa-times text-danger redeem_code_clear" data-id="1"></i>
      </label>
        <div class="form-group">
          <input type="text" class="form-control" name="redeem_code[0][code]" id="redeem_code_1" value="{{$payment->discountVouchers->first() ? $payment->discountVouchers->first()->code:""}}">
        </div>
    </div>
    <div  class="col-6">
      <label>Discount Amount</label>
        <div class="form-group">
          <input type="text" class="form-control" name="redeem_code[0][amount]" id="redeem_code_1_amount" value="{{$payment->discountVouchers->first() ? $payment->discountVouchers->first()->discount_amount:0}}">
        </div>
    </div>
  </div>

  <div class="row">
    <div  class="col-6">
      <label>Redeem Voucher 2
        <i class="fas fa-search search-voucher text-info" data-toggle="modal" data-target="#patient-vouchers-modal"></i>
        <i class="fas fa-times text-danger redeem_code_clear" data-id="2"></i>
      </label>
        <div class="form-group">
          <input type="text" class="form-control" name="redeem_code[1][code]" id="redeem_code_2" value="{{isset($payment->discountVouchers[1]) ? $payment->discountVouchers->last()->code:''}}">
        </div>

    </div>
    <div  class="col-6">
      <label>Discount Amount</label>
        <div class="form-group">
          <input type="text" class="form-control" name="redeem_code[1][amount]" id="redeem_code_2_amount" value="{{isset($payment->discountVouchers[1]) ? $payment->discountVouchers->last()->discount_amount:0}}">
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

@push('js')
<script>
$(function(){

  $(document).on('click', '.cp-code', function(){
    var pasteCode = $(this).data('code');
    if($("#redeem_code_1").val()=='') {
      $("#redeem_code_1").val(pasteCode);
      //$("#redeem_code_1_amount").removeAttr("disabled");
    } else if ($("#redeem_code_2").val()=='') {
      $("#redeem_code_2").val(pasteCode);
      //$("#redeem_code_2_amount").removeAttr("disabled");
    } else {
      alert("Pleae Clear Code");
      return false;
    }

    $('#patient-vouchers-modal').modal('hide');
    $("#wrp-"+pasteCode).hide();
  });

  $(document).on('click', '.redeem_code_clear', function(){
    var clearCode = $(this).data('id');
    var codeVal = $("#redeem_code_"+clearCode).val();
    $("#redeem_code_"+clearCode).val('');
    $("#redeem_code_"+clearCode+'_amount').val(0);
    $("#wrp-"+codeVal).show();
    getvalues();
  });


});

</script>
@endpush
