@extends('layouts.app', ['titlePage' => 'Patient: '. $patient->fullname.', '.$patient->gender.', '.$age])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('treat.card')
          </div>

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">
            <form action="{{ route('treat.store', ['patient' => $patient, 'matter' => $matter]) }}" method="post">
              @csrf

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="branch_id" class="d-block">Branch</label>
                    {!! Form::select('treat[branch_id]', [null=>'Please Select'] + $branches, null, array('class' => 'form-control', 'id' => 'branch_id')) !!}
                    @error('treat.branch_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="user_id" class="d-block">Treat By</label>
                    {!! Form::select('treat[user_id]', [null=>'Please Select'] + $users, auth()->user()->id, array('class' => 'form-control', 'id' => 'user_id')) !!}
                    @error('treat.user_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <label for="gemder" class="d-block">Treatment Date & Time</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="flatpickr datetimepicker form-control" name="treat[treat_date]" type="text" placeholder="Date & Time" value="{{ old('treat.treat_date') }}">
                    </div>
                    @error('treat.treat_date')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>



                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Treatment</label>
                    <textarea class="form-control" id="treatment" name="treat[treatment]" rows="3" placeholder="Enter Treatment">{{ old('treat.treatment') }}</textarea>
                    @error('treat.treatment')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Remarks</label>
                    <textarea class="form-control" id="remarks" name="treat[remarks]" rows="3" placeholder="Enter Remarks">{{ old('treat.remarks') }}</textarea>
                    @error('treat.remarks')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>








              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              <button type="submit" name="submit" value="new-treat" class="btn btn-primary">Submit & New Treatment</button>

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
    maxDate: "today",
    minTime: "10:00",
    maxTime: "18:00",
    defaultHour: {{date('H')}},
    defaultMinute: {{date('i')}}
  });
});
</script>
@endpush
