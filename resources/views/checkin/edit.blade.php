@extends('layouts.app', ['titlePage' => 'New Check-In : '. $checkin->patient->fullname])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-11 order-xl-1">
        <div class="card-body">

            <form action="{{route('checkin.update',$checkin)}}" method="post" autocomplete="off">
              <input autocomplete="false" name="hidden" type="text" style="display:none;">
              @csrf
              {{ Form::hidden('patient_id', $checkin->patient_id ?? '') }}
              {{ Form::hidden('matter_id', $checkin->matter_id ?? '') }}
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label for="branch_id" class="d-block">Branch</label>
                    @php
                    if(Session::get('myBranch')) {
                      $defBranch = session('myBranch')->id;
                    } else {
                      $defBranch = null;
                    }
                    @endphp
                    {!! Form::select('branch_id', [null=>'Please Select'] + $branches, $checkin->branch_id, array('class' => 'form-control', 'id' => 'branch_id')) !!}
                    @error('branch_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label for="branch_id" class="d-block">Master</label>
                    {!! Form::select('user_id', [null=>'Please Select'] + $users, $checkin->user_id, array('class' => 'form-control', 'id' => 'user_id')) !!}
                    @error('user_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

            </form>
         </div>


      </div>


      </div>

      </div>

    </div>


@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<style>
.datepicker table tr td.today,  .datepicker table tr td.today:hover {
  background-color: #ccc;
}

.datetimepicker {
  background-color: #fff !important;
}

</style>
@endpush

@push('js')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

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
    maxTime: "18:00",
    minuteIncrement: 60,
    defaultHour: {{date('H')}}
  });

});
</script>
@endpush
