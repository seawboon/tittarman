@extends('layouts.app', ['titlePage' => 'Transfer Voucher'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">

            {{ Form::model($voucher, array('route' => array('voucher.transfer.update', $patient, $voucher), 'method' => 'POST')) }}


              <div class="row">

                <div class="col-12">
                  <div class="form-group">
                    <label for="name">Voucher Code</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" value="{{ old('name', $voucher->code) }}" readonly>
                    @error('name')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="owner_id">Owner:</label>
                    {{ $voucher->patient->salutation }} {{ $voucher->patient->fullname }}

                    <input type="hidden" class="form-control" id="owner_id" name="owner_id" value="{{ $voucher->patient->id }}">
                    @error('owner_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="patient_id">Transfer to:</label>

                    <select class="js-example-basic-single w-100" id="patient_id" name="patient_id" required>
                      <option value="">Transfer To</option>
                      @foreach($patients as $tpatient)
                        <option value="{{$tpatient->id}}">{{$tpatient->id}}. <small>{{$tpatient->salutation}}</small> {{$tpatient->fullname}}</option>
                      @endforeach
                    </select>

                    @error('patient_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>


              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary mt-4">Transfer</button>


            {{ Form::close() }}
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
@endpush
