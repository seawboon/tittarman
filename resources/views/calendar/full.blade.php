<div class="card shadow">
    <div class="card-header bg-transparent">
        <div class="row align-items-center">
            <div class="col-6">
              <h2 class="mb-0">Appointment</h2>
            </div>
            <div class="col-6 text-right">
              <a class="btn btn-sm btn-info mb-3" href="{{ route('appointments.create') }}">New Appointment</a>
            </div>
            <div class="col">
                <h4 class="master-label">
                  <span class="badge text-white" style="background-color:#3788d8">No Master</span>
                  {{--@foreach($calendar['master'] as $master)
                    <span class="badge text-white" style="background-color:{{$master->color}}">{{$master->name}}</span>
                  @endforeach--}}
                </h4>
            </div>
        </div>
    </div>
    <div class="card-body">
      <div id='calendar'></div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('appointments.store') }}" method="post" autocomplete="off">
          @csrf
          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="branch_id" class="d-block">Branch</label>
                {!! Form::select('branch_id', [null=>'Please Select'] + \App\Branches::pluck('name','id')->all(), null, array('class' => 'form-control', 'id' => 'branch_id')) !!}
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
                  <input class="flatpickr datetimepicker form-control" name="appointment_date" id="appointment_date" type="text" placeholder="Date & Time" value="">
                </div>
                @error('appointment_date')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="user_id" class="d-block">Master</label>
                {!! Form::select('user_id', [null=>'Please Select'], null, array('class' => 'form-control', 'id' => 'user_id')) !!}
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
                  <option value="Datuk Seri">Datuk Seri</option>
                  <option value="Dato Sri">Dato Sri</option>
                  <option value="Datin Seri">Datin Seri</option>
                  <option value="Datuk">Datuk</option>
                  <option value="Dato">Dato</option>
                  <option value="Datin">Datin</option>
                  <option value="Dr">Dr</option>
                  <option value="Mr">Mr</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Master">Master</option>
                  <option value="Miss">Miss</option>
                  <option value="Prof">Prof</option>
                  <option value="Puan Sri">Puan Sri</option>
                  <option value="Tan Sri">Tan Sri</option>
                </select>

                @error('salutation')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="name">Name <small>as per NRIC / Passport</small></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" value="">
                @error('name')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                @error('email')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="contact">Contact</label>
                <div class="row">
                  <div class="col-5 pr-0">
                    <select class="form-control" id="provider" name="provider">
                      <option value="">Select</option>
                      <option value="010">010</option>
                      <option value="011">011</option>
                      <option value="012">012</option>
                      <option value="013">013</option>
                      <option value="014">014</option>
                      <option value="016">016</option>
                      <option value="017">017</option>
                      <option value="018">018</option>
                      <option value="019">019</option>
                    </select>
                    @error('provider')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                  <div class="col-7">
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" minlength="7" maxlength="8" value="">
                    @error('contact')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="branch_id" class="d-block">Source</label>
                {!! Form::select('source', [null=>'Please Select'] + \App\AppointmentSource::pluck('name','id')->all(), '', array('class' => 'form-control', 'id' => 'source')) !!}
                @error('source')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="address">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="1" placeholder="Enter Remarks"></textarea>
                @error('remarks')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-12 text-center">
            <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>

@push('css')
<link rel="stylesheet" href="{{ asset('css/fullcalendar/main.css') }}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.datepicker table tr td.today,  .datepicker table tr td.today:hover {
  background-color: #ccc;
}

.datetimepicker {
  background-color: #fff !important;
}
/*.fc-media-screen .fc-timegrid-event-harness, .fc-media-screen .fc-timegrid-event {
  position: relative !important;
  left: 0 !important;
  margin-right: 0 !important;
}*/
.fc-resourceTimeGridDay-view .fc-event-time {
  display: none;
}

.MV-s .fc-list-event-title::before {
  content: 'MV ';
  color: purple;
  font-size: 0.75rem;
}

.ARK-s .fc-list-event-title::before {
  content: 'AR ';
  color: red;
  font-size: 0.75rem;
}

.fc .fc-list-event-dot {
  border :10px solid;
}
</style>
@endpush

@push('js')
<script src="{{ asset('js/fullcalendar/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script>
$(document).ready(function() {
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

    //var url = "{{URL('userData')}}";
    var branches;
    var event_list;
    $.ajax({
        url: "/api/calendar",
        type: "GET",
        data:{
            _token:'{{ csrf_token() }}'
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
            //console.log(dataResult);
            branches = dataResult.calendar.branches;
            event_list = dataResult.calendar.events;
            masterLabel = dataResult.calendar.master;

            $.each( masterLabel, function( i, val ) {
              var itemAppend = '<span class="badge text-white ml-2" style="background-color:'+val.color+'">'+val.name+'</span>';
              var o = new Option(val.name, val.id);
              $("#user_id").append(o);
              $('.master-label').append(itemAppend);
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
              schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
              initialView: 'resourceTimeGridDay',
              initialDate: '{{Carbon\Carbon::now()}}',
              slotMinTime: '10:00',
              slotMaxTime: '21:00',
              slotEventOverlap: false,
              editable: true,
              selectable: true,
              dayMaxEvents: true, // allow "more" link when too many events
              //dayMinWidth: 200,
              displayEventTime: true,
              businessHours: {
                //daysOfWeek: [ 1, 2, 3, 4, 5, 6, 7 ],
                startTime: '10:00', // a start time (10am in this example)
                endTime: '21:00',
              },
              headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                //right: 'resourceTimeGridDay,resourceTimeGridTwoDay,resourceTimeGridWeek,dayGridMonth'
                right: 'resourceTimeGridDay,resourceTimeGridWeek,listDay'
              },
              views: {
                resourceTimeGridTwoDay: {
                  type: 'resourceTimeGrid',
                  duration: { days: 3 },
                  buttonText: '3 days',
                }
              },

              //// uncomment this line to hide the all-day slot
              allDaySlot: false,
              resourceOrder: '-id',
              resources: branches,

              events: event_list,

              select: function(arg) {
                console.log(
                  'select',
                  arg.startStr,
                  arg.endStr,
                  arg.resource ? arg.resource.id : '(no resource)'
                );
              },
              dateClick: function(arg) {
                console.log(
                  'dateClick',
                  arg.date,
                  arg.resource ? arg.resource.id : '(no resource)'
                );
                $('.modal-title').html(arg.dateStr);
                $('[name="branch_id"]').val(arg.resource.id);
                $('#appointment_date').val('2020-10-21 12:00');
                $('#myModal').modal('show');
              }
            });

            calendar.render();
        }
    });


});
</script>
@endpush
