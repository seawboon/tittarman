@extends('layouts.app', ['titlePage' => 'Edit Appointment'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-11 order-xl-1">
        <div class="card-body">
            {{ Form::model($appo, array('route' => array('appointments.update', $appo->id), 'method' => 'PUT')) }}
            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            @csrf
            {{ Form::hidden('patient_id', $appo->patient_id) }}
            {{ Form::hidden('matter_id', $appo->matter_id) }}
            {{ Form::hidden('appointment_id', $appo->id) }}
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label for="branch_id" class="d-block">Branch</label>
                  {!! Form::select('branch_id', [null=>'Please Select'] + $branches, $appo->branch_id, array('class' => 'form-control', 'id' => 'branch_id')) !!}
                  @error('branch_id')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <label for="gemder" class="d-block">Appointment Date & Time</label>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="flatpickr datetimepicker form-control" name="appointment_date" type="text" placeholder="Date & Time" value="{{ $appo->appointment_date }}">
                  </div>
                  @error('appointment_date')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="branch_id" class="d-block">Master</label>
                  {!! Form::select('user_id', [null=>'Please Select'] + $users, $appo->user_id, array('class' => 'form-control', 'id' => 'user_id')) !!}
                  @error('user_id')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="title">Title</label>
                  <select class="form-control" id="salutation" name="salutation">
                    <option value="" selected="selected">Please Select</option>
                    <option value="Datuk Seri" {{($appo->salutation == 'Datuk Seri') ? 'selected' : ''}}>Datuk Seri</option>
                    <option value="Dato Sri" {{($appo->salutation == 'Dato Sri') ? 'selected' : ''}}>Dato Sri</option>
                    <option value="Datin Seri" {{($appo->salutation == 'Datin Seri') ? 'selected' : ''}}>Datin Seri</option>
                    <option value="Datuk" {{($appo->salutation == 'Datuk') ? 'selected' : ''}}>Datuk</option>
                    <option value="Dato" {{($appo->salutation == 'Dato') ? 'selected' : ''}}>Dato</option>
                    <option value="Datin" {{($appo->salutation == 'Datin') ? 'selected' : ''}}>Datin</option>
                    <option value="Dr" {{($appo->salutation == 'Dr') ? 'selected' : ''}}>Dr</option>
                    <option value="Mr" {{($appo->salutation == 'Mr') ? 'selected' : ''}}>Mr</option>
                    <option value="Mrs" {{($appo->salutation == 'Mrs') ? 'selected' : ''}}>Mrs</option>
                    <option value="Master" {{($appo->salutation == 'Master') ? 'selected' : ''}}>Master</option>
                    <option value="Miss" {{($appo->salutation == 'Miss') ? 'selected' : ''}}>Miss</option>
                    <option value="Prof" {{($appo->salutation == 'Prof') ? 'selected' : ''}}>Prof</option>
                    <option value="Puan Sri" {{($appo->salutation == 'Puan Sri') ? 'selected' : ''}}>Puan Sri</option>
                    <option value="Tan Sri" {{($appo->salutation == 'Tan Sri') ? 'selected' : ''}}>Tan Sri</option>
                  </select>

                  @error('salutation')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="name">Name <small>as per NRIC / Passport</small></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" value="{{ $appo->name }}">
                  @error('name')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $appo->email }}">
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
                        <option value="010" {{($appo->provider == '010') ? 'selected' : ''}}>010</option>
                        <option value="011" {{($appo->provider == '011') ? 'selected' : ''}}>011</option>
                        <option value="012" {{($appo->provider == '012') ? 'selected' : ''}}>012</option>
                        <option value="013" {{($appo->provider == '013') ? 'selected' : ''}}>013</option>
                        <option value="014" {{($appo->provider == '014') ? 'selected' : ''}}>014</option>
                        <option value="016" {{($appo->provider == '016') ? 'selected' : ''}}>016</option>
                        <option value="017" {{($appo->provider == '017') ? 'selected' : ''}}>017</option>
                        <option value="018" {{($appo->provider == '018') ? 'selected' : ''}}>018</option>
                        <option value="019" {{($appo->provider == '019') ? 'selected' : ''}}>019</option>
                      </select>
                      @error('provider')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" minlength="7" maxlength="8" value="{{ $appo->contact }}">
                      @error('contact')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label for="address">Remarks</label>
                  <textarea class="form-control" id="remarks" name="remarks" rows="2" placeholder="Enter Remarks">{{ $appo->remarks }}</textarea>
                  @error('remarks')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="branch_id" class="d-block">Source</label>
                  {!! Form::select('source', [null=>'Please Select'] + \App\AppointmentSource::pluck('name','id')->all(), $appo->source, array('class' => 'form-control', 'id' => 'source')) !!}
                  @error('source')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="state" class="d-block">State</label>
                  {!! Form::select('state', ['awaiting'=>'Awaiting', 'cancelled'=>'Cancelled', 'checkin'=>'Check In'], $appo->state, array('class' => 'form-control', 'id' => 'state')) !!}
                  @error('state')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

            </div>



            <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

          {{ Form::close() }}

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

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
$(document).ready(function() {
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
    enableTime: true,
    altInput: true,
    altFormat: "F j, Y H:i",
    dateFormat: "Y-m-d H:i",
    minDate: new Date().fp_incr(0),
    minTime: "10:00",
    maxTime: "20:00",
    minuteIncrement: 60,
    defaultHour: {{date('H')}}
  });

});
</script>
@endpush
