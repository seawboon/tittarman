<div for="Vouchers">
  @if(!$payment->PatientPackage)
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
        <option value="">Choose Package Variant</option>
      </select>
    </div>

  @else

    <input type="hidden" name="variantValue" class="variantValue" value="{{$payment->PatientPackage->alacarte->sell ? $payment->PatientPackage->alacarte->sell : $payment->PatientPackage->variant->sell}}" />
    <small class="d-block">Package :</small>
    <label for="days" class="d-block">{{$payment->PatientPackage->package->title}}</label>
    <small class="d-block">Variant :</small>
    <label for="days" class="d-block">{{$payment->PatientPackage->variant->name}} - RM {{$payment->PatientPackage->alacarte->sell ? $payment->PatientPackage->alacarte->sell : $payment->PatientPackage->variant->sell}}</label>
    <small class="d-block">Vouchers :</small>
    <label for="days" class="d-block">
      @foreach($payment->PatientPackage->patientVouchers as $patientVoucher)
        <small class="d-block">{{$patientVoucher->code}}</small>
      @endforeach
    </label>
  @endif
  <div id="ala-carte-details">
    <div class="row">
      <div class="col-12 col-md-4">
        <label for="alacartquantity">Quantity <small class="text-danger">required</small></label>
        {!! Form::select('alacart[quantity]', range(0, 10) , null, array('class' => 'form-control', 'id'=>'alacartquantity', 'required')) !!}
      </div>
      <div class="col-12 col-md-4">
        <div class="form-group">
          <label for="sell">Price <small class="text-danger">required</small></label>
          <input type="text" class="form-control" id="alacartsell" name="alacart[sell]" placeholder="Enter Selling Price" value="0">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="form-group">
          <label for="title">Expiry <small class="text-danger">required</small></label>
          <select class="form-control" name="alacart[expiry]">
            <option value="">Please Choose</option>
            <option value="1">1 month</option>
            <option value="3">3 months</option>
            <option value="6">6 months</option>
            <option value="9">9 months</option>
            <option value="12">12 months</option><option value="15">15 months</option><option value="18">18 months</option><option value="21">21 months</option><option value="24">24 months</option><option value="27">27 months</option><option value="30">30 months</option><option value="33">33 months</option><option value="36">36 months</option></select>
        </div>
      </div>
    </div>

  </div>
  <div id="voucher-details"></div>
  <button class="btn-sm btn-warning mt-2" id="chk-code">Check Cobe Availability <div class="loader"></div></button>
  <span id="hidden-chkbox"></span>

  {{-- <div id="packageContent">
    @foreach($packages as $key => $package)
    <div class="pkg-{{$package->id}}" id="{{$package->slug}}">
      <ul>
      @foreach($package->variants as $key => $variant)
      <li>
        {{$variant->name}} ({{ $variant->sku }})<del>{{$variant->price}}</del> {{$variant->sell}}

        @foreach($variant->vouchers  as $key => $voucher)
        <div class="border border-primary p-1 mb-1">
          {{$voucher->type->name}} * {{$voucher->quantity}}
          @for ($i = 1; $i <= $voucher->quantity; $i++)
            <input type="text" class="form-control" name="asda" value="{{ old('asda', $voucher->prefix) }}" />
          @endfor
        </div>
        @endforeach

      </li>
      @endforeach
      </ul>
    </div>
    @endforeach
  </div> --}}
</div>
