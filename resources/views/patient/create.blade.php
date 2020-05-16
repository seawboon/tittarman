@extends('layouts.app', ['titlePage' => __('Patients')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
        <div class="container">
          <div class="card-body">
              <form action="{{ route('patient.store') }}" method="post">
                @csrf

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="branch_id" class="d-block">Branch</label>
                      {!! Form::select('branch_id', [null=>'Please Select'] + $branches, null, array('class' => 'form-control', 'id' => 'branch_id')) !!}
                      @error('branch_id')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="salutation" name="salutation" value="{{ old('salutation') }}" placeholder="Enter Title">
                      @error('salutation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="fullname">Full Name</label>
                      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" value="{{ old('fullname') }}">
                      @error('fullname')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="gemder" class="d-block">Gender</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="Male" value="male" {{(old('gender') == 'male') ? 'checked' : ''}}>
                        <label class="form-check-label" for="Male">Male</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="Female" value="female" {{(old('gender') == 'female') ? 'checked' : ''}}>
                        <label class="form-check-label" for="Female">Female</label>
                      </div>

                      @error('gender')
                      <small class="text-danger d-block">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <label for="gemder" class="d-block">Date of Birth</label>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Select date" type="text" id="dob" name="dob" value="{{ old('dob') }}">

                        </div>
                        @error('dob')
                        <small class="text-danger d-block">{{ $message}}</small>
                        @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="nric">NRIC / Passport</label>
                      <input type="text" class="form-control" id="nric" name="nric" placeholder="Enter NRIC/Passport" value="{{ old('nric') }}">
                      @error('nric')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                      @error('email')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="contact">Contact</label>
                      <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" value="{{ old('contact') }}">
                      @error('contact')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="occupation">Occupation</label>
                      <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Enter Occupation" value="{{ old('occupation') }}">
                      @error('occupation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="sensitive_skin" class="d-block">Sensitive Skin</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sensitive_skin" id="ss_yes" value="yes" {{(old('sensitive_skin') == 'yes') ? 'checked' : ''}}>
                        <label class="form-check-label" for="ss_yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sensitive_skin" id="ss_no" value="no" {{(old('sensitive_skin') == 'no') ? 'checked' : ''}}>
                        <label class="form-check-label" for="ss_no">No</label>
                      </div>

                      @error('sensitive_skin')
                      <small class="text-danger d-block">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address">{{ old('address') }}</textarea>
                      @error('address')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                </div>


                <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

                <button type="submit" name="submit" value="new-case" class="btn btn-primary">Submit & New Case</button>

              </form>
           </div>



        </div>

    </div>


@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>


<script>
$(document).ready(function() {
  $('.datepicker').datepicker({});
});
</script>
@endpush
