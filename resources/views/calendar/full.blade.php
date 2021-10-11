<div class="card shadow">
    <div class="card-header bg-transparent">
        <div class="row align-items-center">
            <div class="col-6">
              <h2 class="mb-0">Appointment</h2>
            </div>
            <div class="col-6 text-right">
              {{--<a class="btn btn-sm btn-info mb-3" href="{{ route('appointments.create') }}">New Appointment</a>--}}
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
        {{--<h4 class="modal-title">Modal Header</h4>--}}
      </div>
      <div class="modal-body">
        <form id="appointment_form" action="javascript:void(0)" method="post" autocomplete="off">
          @csrf
          {{ Form::hidden('patient_id', $extra['patient']['id'] ?? '') }}
          {{ Form::hidden('matter_id', $extra['matter']['id'] ?? '') }}

          <div class="alert" id="msg_div" style="display:none">
            <span id="res_message"></span>
          </div>

          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label for="branch_id" class="d-block">Branch<span class="text-danger">*</span></label>
                {!! Form::select('branch_id', [null=>'Please Select'] + \App\Branches::pluck('name','id')->all(), null, array('class' => 'form-control', 'id' => 'branch_id', 'required' => 'required')) !!}
                @error('branch_id')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <label for="gemder" class="d-block">Appointment Date & Time<span class="text-danger">*</span></label>
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
                <label for="name">Name <small>as per NRIC / Passport</small><span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" value="" required>
                @error('name')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ isset($extra['patient']['email']) ? $extra['patient']['email']:''}}">
                @error('email')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>
            </div>

            <div class="col-4">
              <div class="form-group">
                <label for="contact">Contact<span class="text-danger">*</span></label>
                <div class="row">
                  <div class="col-5 pr-0">
                    <select class="form-control" id="provider" name="provider" required>
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
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" minlength="7" maxlength="8" required>
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
            <button id="form-submit" type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>
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

.fc-v-event .fc-event-main-frame {
    height: 100%;
    display: flex;
    /*flex-direction: column;*/
    /* boon add */
    flex-direction: row;
    overflow: hidden;
  }

  .fc-v-event .fc-event-title { /* will have fc-sticky on it */
      top: 0;
      bottom: 0;
      /*max-height: 100%;  clip overflow */

      overflow: hidden;
      /*boon add */
      max-height: 17px; /* clip overflow */
      font-size: var(--fc-small-font-size, .85em);
    }
    .fc-media-screen .fc-timegrid-event {
        position: absolute; /* absolute WITHIN the harness */
        top: 0;
        bottom: 1px; /* stay away from bottom slot line */
        left: 0;
        right: 0;
        /*boon add */
        height: 25px;
      }
</style>

<style>

  /*
  i wish this required CSS was better documented :(
  https://github.com/FezVrasta/popper.js/issues/674
  derived from this CSS on this page: https://popper.js.org/tooltip-examples.html
  */

  .popper,
  .tooltip {
    position: absolute;
    z-index: 9999;
    background: #FFC107;
    color: black;
    width: 150px;
    border-radius: 3px;
    /*box-shadow: 0 0 2px rgba(0,0,0,0.5);
    padding: 10px;*/
    text-align: center;
    opacity: 1 !important;
  }
  .style5 .tooltip {
    background: #1E252B;
    color: #FFFFFF;
    max-width: 200px;
    width: auto;
    font-size: .8rem;
    padding: .5em 1em;
  }
  .popper .popper__arrow,
  .tooltip .tooltip-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
    margin: 5px;
  }

  .tooltip .tooltip-arrow,
  .popper .popper__arrow {
    border-color: #FFC107;
  }
  .style5 .tooltip .tooltip-arrow {
    border-color: #1E252B;
  }
  .popper[x-placement^="top"],
  .tooltip[x-placement^="top"] {
    margin-bottom: 5px;
  }
  .popper[x-placement^="top"] .popper__arrow,
  .tooltip[x-placement^="top"] .tooltip-arrow {
    border-width: 5px 5px 0 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    bottom: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .popper[x-placement^="bottom"],
  .tooltip[x-placement^="bottom"] {
    margin-top: 5px;
  }
  .tooltip[x-placement^="bottom"] .tooltip-arrow,
  .popper[x-placement^="bottom"] .popper__arrow {
    border-width: 0 5px 5px 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-top-color: transparent;
    top: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .tooltip[x-placement^="right"],
  .popper[x-placement^="right"] {
    margin-left: 5px;
  }
  .popper[x-placement^="right"] .popper__arrow,
  .tooltip[x-placement^="right"] .tooltip-arrow {
    border-width: 5px 5px 5px 0;
    border-left-color: transparent;
    border-top-color: transparent;
    border-bottom-color: transparent;
    left: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }
  .popper[x-placement^="left"],
  .tooltip[x-placement^="left"] {
    margin-right: 5px;
  }
  .popper[x-placement^="left"] .popper__arrow,
  .tooltip[x-placement^="left"] .tooltip-arrow {
    border-width: 5px 0 5px 5px;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    right: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }

</style>
@endpush

@push('js')
<script src="{{ asset('js/fullcalendar/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
<script>
$(document).ready(function() {

    //var url = "{{URL('userData')}}";
    var branches;
    var event_list;
    var calendarEl = document.getElementById('calendar');
    var calendar = null;
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


            var currentType = null;
            calendar = new FullCalendar.Calendar(calendarEl, {
              schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
              initialView: 'resourceTimeGridDay',
              initialDate: '{{Carbon\Carbon::now()}}',
              slotMinTime: '10:00',
              slotMaxTime: '21:00',
              slotLabelInterval: '00:30:00',
              slotDuration: '00:30:00',
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
                resourceTimeGridDay: {
                  buttonText: 'Day',
                },
                resourceTimeGridWeek: {
                  buttonText: 'Week',
                },
                listDay: {
                  buttonText: 'List',
                },
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

              eventDidMount: function(info) {
                console.log(info.event.extendedProps.description);
                var tooltip = new Tooltip(info.el, {
                  title: info.event.extendedProps.description,
                  placement: 'top',
                  trigger: 'hover',
                  container: 'body'
                });
              },

              events: event_list,



              /*select: function(arg) {
                console.log(
                  'select',
                  arg.startStr,
                  arg.endStr,
                  arg.resource ? arg.resource.id : '(no resource)'
                );
              },*/

              eventDrop: function(event, delta, revertFunc) {
                var infoResources = event.event.getResources();
                var resourceId = infoResources[0]._resource.id;
                //alert(event.event.startStr);
                //alert(event.event.id);
                //alert(resourceId);
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                $.ajax({
                  url: "/api/calendarput/"+event.event.id,
                  method: 'put',
                  data:{
                      appointment_date: event.event.startStr,
                      branch_id: resourceId,
                  },
                  cache: false,
                  //dataType: 'json',
                  success: function(result) {
                    //console.log(result);
                  }
                });

              },

              dateClick: function(arg) {
                /*console.log(
                  'dateClick',
                  arg.date,
                  arg.resource ? arg.resource.id : '(no resource)'
                );*/
                //$('.modal-title').html(arg.dateStr);
                $('[name="branch_id"]').val(arg.resource.id);
                $('#appointment_date').val(arg.dateStr);
                @isset($extra['patient']['salutation'])
                  $('[name="salutation"').val('{{$extra['patient']['salutation']}}');
                @endisset
                @isset($extra['patient']['fullname'])
                  $('[name="name"').val('{{$extra['patient']['fullname']}}');
                @endisset
                @isset($extra['patient']['contact'])
                  $('[name="contact"').val('{{$extra['patient']['contact']}}');
                @endisset
                @isset($extra['patient']['provider'])
                  $('[name="provider"').val('{{$extra['patient']['provider']}}');
                @endisset

                $('#appointment_date').val(arg.dateStr);

                flatpickr('.datetimepicker', {
                  enableTime: true,
                  altInput: true,
                  altFormat: "F j, Y H:i",
                  dateFormat: "Y-m-d H:i",
                  minDate: new Date().fp_incr(0),
                  minTime: "10:00",
                  maxTime: "20:00",
                  minuteIncrement: 30,
                  //defaultHour: {{date('H')}}
                });

                $('#myModal').modal('show');
              }
            });

            calendar.render();
        }
    });




  $('#form-submit').on('click', function(e) {
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      if($('#name').val() && $('#provider').val() && $('#contact').val() && $.isNumeric($('#contact').val()) && $('#branch_id').val() && $('#appointment_date').val()) {

      $('#form-submit').html('Sending...');

      $.ajax({
        url: "/api/calendarpost",
        method: 'post',
        data: $('#appointment_form').serialize(),
        success: function(result) {
          $('#form-submit').html('Submit');
          if(result.status) {
            $('#res_message').html(result.msg);
            $('#msg_div').removeClass('alert-danger');
            $('#msg_div').addClass('alert-success');
            $('#msg_div').show();
            $('#res_message').show();

            calendar.addEvent({
              id: result.event_id,
              resourceId: result.resourceId,
              classNames: result.classNames,
              start: result.start,
              title: result.title,
              url: result.url,
              color: result.color
            });

          } else {
            alert('please complete form');
            $('#res_message').html(result.msg);
            $('#msg_div').removeClass('alert-success');
            $('#msg_div').addClass('alert-danger');
            $('#msg_div').show();
            $('#res_message').show();
          }

          //document.getElementById("appointment_form").reset();
          setTimeout(function(){
            $('#res_message').hide();
            $('#msg_div').hide();
          }, 1500);

        }
      });
    } else {
      alert('plrase complete form');
    }

  });

});
</script>
@endpush
