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
