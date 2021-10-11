<div class="resp-tabs-container ver_1">
    @include('payment.includes.edit.products')

    @include('payment.includes.edit.vouchers')

    @include('payment.includes.edit.treatment_fee')

    @include('payment.includes.edit.myvoucher')


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
