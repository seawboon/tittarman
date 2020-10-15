@extends('layouts.app', ['titlePage' => __('Appointments')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div>
            {{--<a class="btn btn-sm btn-info mb-3" href="{{ route('appointments.create') }}">New Appointment</a>--}}
            <div class="row pb-3">
              <div class="col">
                @include('calendar.full')
              </div>
            </div>

          </div>

        </div>

    </div>


@endsection

@push('css')
<style>
.form-control-sm{
  background-color: transparent;
  outline:0;
  border: 0;
  color: rgba(255, 255, 255, .9);
}

.form-control-sm::placeholder, .input-group-text-sm
{
  color: rgba(255, 255, 255, .75);
}

</style>
@endpush

@push('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function() {
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
    mode: "range",
    enableTime: false,
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    //defaultDate: ['2020-07-09 00:00:00', '2020-07-19 00:00:00'],
    /*disable: [
        function(date) {
            // disable every multiple of 8
            return !(date.getDate() % 8);
        }
    ]*/
  });


});
</script>

@endpush
