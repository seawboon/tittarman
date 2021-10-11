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
