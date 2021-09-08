@extends('layouts.app', ['titlePage' => 'Edit Appointment Source'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">

            {{--<form action="{{ route('sources.update', ($source) ) }}" method="PUT">--}}
            {{ Form::model($promotion, array('route' => array('promotions.update', $promotion), 'method' => 'PUT')) }}


              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Promotion Name</label>
                    <input type="text" class="form-control" id="name" name="promotion[name]" placeholder="Enter Promotion Name" value="{{ old('promotion.name', $promotion->name) }}">
                    @error('promotion.name')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="code">Promotion Code</label>
                    <input type="text" class="form-control" id="code" name="promotion[code]" placeholder="Enter Promotion Code" value="{{ old('promotion.code', $promotion->code) }}">
                    @error('promotion.code')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="type" class="d-block">Promotion Type <small class="text-danger">required</small></label>
                    {!! Form::select('promotion[type]', [null=>'Please Select'] + $types['promotion'], $promotion->type, array('class' => 'form-control', 'id' => 'type')) !!}
                    @error('promotion.type')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="address">Description</label>
                    <textarea class="form-control" id="description" name="promotion[description]" rows="2" placeholder="Enter description">{{ old('promotion.description', $promotion->description) }}</textarea>
                    @error('promotion.description')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <label for="began_at" class="d-block">Publish Start On <small class="text-danger">required</small></label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="flatpickr datetimepicker form-control" name="promotion[began_at]" type="text" placeholder="Date & Time" value="{{ old('promotion.began_at', $promotion->began_at) }}">
                    </div>
                    @error('promotion.began_at')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <label for="ended_at" class="d-block">Publish End On <small class="text-danger">required</small></label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="flatpickr datetimepicker form-control" name="promotion[ended_at]" type="text" placeholder="Date & Time" value="{{ old('promotion.ended_at', $promotion->ended_at) }}">
                    </div>
                    @error('promotion.ended_at')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                    <label for="ruletype" class="d-block">Rule Type <small class="text-danger">required</small></label>
                    {!! Form::select('rule[type]', [null=>'Please Select'] + $types['rule'], $promotion->rule->type, array('class' => 'form-control', 'id' => 'ruletype')) !!}
                    @error('rule.type')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="ruleAmount">Minimum Amount</label>
                    <input type="text" class="form-control" id="ruleAmount" name="rule[config][amount]" placeholder="Enter Minimum Amount" value="{{ old('rule.config.amount', $promotion->rule->config['amount']) }}">
                    @error('rule.config.amount')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                    <label for="actiontype" class="d-block">Action Type <small class="text-danger">required</small></label>
                    {!! Form::select('action[type]', [null=>'Please Select'] + $types['action'], $promotion->action->type, array('class' => 'form-control', 'id' => 'actiontype')) !!}
                    @error('action.type')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="actionAmount">Discount Amount</label>
                    <input type="text" class="form-control" id="actionAmount" name="action[config][amount]" placeholder="Enter Minimum Amount" value="{{ old('action.config.amount', $promotion->action->config['amount']) }}">
                    @error('action.config.amount')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>



              </div>



              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              {{-- <button type="submit" name="submit" value="new" class="btn btn-primary">Submit & New Appointment Source</button> --}}


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
    defaultHour: {{date('H')}},
    defaultMinute: {{date('i')}}
  });

});
</script>
@endpush
