@extends('layouts.app', ['titlePage' => __('New Patients')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
        <div class="container">
          <div class="card-body">
              <form action="{{ route('patient.store') }}" method="post" autocomplete="off">
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                @csrf

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="branch_id" class="d-block">Branch</label>
                      {!! Form::select('branch_id', [null=>'Please Select'] + $branches, $appo['branch_id'], array('class' => 'form-control', 'id' => 'branch_id')) !!}
                      @error('branch_id')
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

                  <div class="col-3">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <select class="form-control" id="salutation" name="salutation">
                        <option value="" selected="selected">Please Select</option>
                        <option value="Datuk Seri" {{(old('salutation') == 'Datuk Seri' or $appo['salutation'] == 'Datuk Seri') ? 'selected' : ''}}>Datuk Seri</option>
                        <option value="Dato Sri" {{(old('salutation') == 'Dato Sri' or $appo['salutation'] == 'Dato Sri') ? 'selected' : ''}}>Dato Sri</option>
                        <option value="Datin Seri" {{(old('salutation') == 'Datin Seri' or $appo['salutation'] == 'Datin Seri') ? 'selected' : ''}}>Datin Seri</option>
                        <option value="Datuk" {{(old('salutation') == 'Datuk' or $appo['salutation'] == 'Datuk') ? 'selected' : ''}}>Datuk</option>
                        <option value="Dato" {{(old('salutation') == 'Dato' or $appo['salutation'] == 'Dato') ? 'selected' : ''}}>Dato</option>
                        <option value="Datin" {{(old('salutation') == 'Datin' or $appo['salutation'] == 'Datin') ? 'selected' : ''}}>Datin</option>
                        <option value="Dr" {{(old('salutation') == 'Dr' or $appo['salutation'] == 'Dr') ? 'selected' : ''}}>Dr</option>
                        <option value="Mr" {{(old('salutation') == 'Mr' or $appo['salutation'] == 'Mr') ? 'selected' : ''}}>Mr</option>
                        <option value="Mrs" {{(old('salutation') == 'Mrs' or $appo['salutation'] == 'Mrs') ? 'selected' : ''}}>Mrs</option>
                        <option value="Master" {{(old('salutation') == 'Master' or $appo['salutation'] == 'Master') ? 'selected' : ''}}>Master</option>
                        <option value="Miss" {{(old('salutation') == 'Miss' or $appo['salutation'] == 'Miss') ? 'selected' : ''}}>Miss</option>
                        <option value="Prof" {{(old('salutation') == 'Prof' or $appo['salutation'] == 'Prof') ? 'selected' : ''}}>Prof</option>
                        <option value="Puan Sri" {{(old('salutation') == 'Puan Sri' or $appo['salutation'] == 'Puan Sri') ? 'selected' : ''}}>Puan Sri</option>
                        <option value="Tan Sri" {{(old('salutation') == 'Tan Sri' or $appo['salutation'] == 'Tan Sri') ? 'selected' : ''}}>Tan Sri</option>
                      </select>

                      @error('salutation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-8">
                    <div class="form-group">
                      <label for="fullname">Name <small>as per NRIC / Passport</small></label>
                      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" value="{{ old('fullname', $appo['name']) }}">
                      @error('fullname')
                      <small class="text-danger">{{ $message}}</small>
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
                      <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email', $appo['email']) }}">
                      @error('email')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="contact">Contact</label>


                      <div class="row">
                        <div class="col-4">
                          <select class="form-control" id="provider" name="provider">
                            <option value="">Please Select</option>
                            <option value="010" {{(old('provider')  == '010' or $appo['provider'] == '010') ? 'selected' : ''}}>010</option>
                            <option value="011" {{(old('provider')  == '011' or $appo['provider'] == '011') ? 'selected' : ''}}>011</option>
                            <option value="012" {{(old('provider')  == '012' or $appo['provider'] == '012') ? 'selected' : ''}}>012</option>
                            <option value="013" {{(old('provider')  == '013' or $appo['provider'] == '013') ? 'selected' : ''}}>013</option>
                            <option value="014" {{(old('provider')  == '014' or $appo['provider'] == '014') ? 'selected' : ''}}>014</option>
                            <option value="016" {{(old('provider')  == '016' or $appo['provider'] == '016') ? 'selected' : ''}}>016</option>
                            <option value="017" {{(old('provider')  == '017' or $appo['provider'] == '017') ? 'selected' : ''}}>017</option>
                            <option value="018" {{(old('provider')  == '018' or $appo['provider'] == '018') ? 'selected' : ''}}>018</option>
                            <option value="019" {{(old('provider')  == '019' or $appo['provider'] == '019') ? 'selected' : ''}}>019</option>
                          </select>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" value="{{ old('contact', $appo['contact']) }}">
                          @error('contact')
                          <small class="text-danger">{{ $message}}</small>
                          @enderror
                        </div>
                      </div>

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
                      <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="{{ old('address') }}">
                      @error('address')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="" value="{{ old('address2') }}">
                      @error('address2')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="address">Postcode</label>
                      <input type="text" class="form-control" id="postcode" name="postcode" placeholder="" value="{{ old('postcode') }}">
                      @error('postcode')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="address">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ old('city') }}">
                      @error('city')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="state">State</label>
                      {!! Form::select('state', [null=>'Please Select'] + $states, null, array('class' => 'form-control')) !!}
                      @error('postcode')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="country">Country</label>
                      {!! Form::select('country', [null=>'Please Select'] + $countries, 'Malaysia', array('class' => 'form-control')) !!}
                      @error('postcode')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">

                        <div class="col-6 col-md-3">
                          <input type="checkbox" name="freegift" class="custom-control-input" id="freegift" value="yes"  {{ old('freegift') == 'yes' ? ' checked' : '' }}>
                          <label class="custom-control-label" for="freegift">Free Gift</label>
                        </div>

                        @error('freegift')
                        <small class="text-danger">{{ $message}}</small>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>


                <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

                <button type="submit" name="submit" value="new-checkin" class="btn btn-primary">Submit & Check-In</button>

                @hasanyrole('Admin|Master')<button type="submit" name="submit" value="new-case" class="btn btn-primary">Submit & New Case</button>@endhasanyrole

              </form>
           </div>



        </div>

    </div>


@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>


<script>
$(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'dd M yyyy',
  });
});
</script>
@endpush
