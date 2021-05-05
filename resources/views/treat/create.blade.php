@extends('layouts.app', ['titlePage' => 'TREATMENT DETAIL: '. $patient->fullname])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('treat.card')
          </div>

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">
            <form action="{{ route('treat.store', ['patient' => $patient, 'matter' => $matter]) }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="branch_id" class="d-block">Branch</label>
                    @php
                      $defBranch = null;
                      if(Session::get('myBranch')) {
                        $defBranch=session('myBranch')->id;
                      }
                    @endphp
                    {!! Form::select('treat[branch_id]', [null=>'Please Select'] + $options['branches'], $defBranch, array('class' => 'form-control', 'id' => 'branch_id')) !!}
                    @error('treat.branch_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                   {{--<div class="form-group">
                    <label for="user_id" class="d-block">Treat By</label>
                    {!! Form::select('treat[user_id]', [null=>'Please Select'] + $users, auth()->user()->id, array('class' => 'form-control', 'id' => 'user_id')) !!}
                    @error('treat.user_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>--}}

                  <div class="form-group">
                    <label for="title">Treat By</label>
                    <?php $oldmasters = [];?>
                    @if(old('masters'))
                      @foreach(old('masters') as $yy)
                        <?php
                          $oldmasters[] = $yy['user_id'];
                        ?>
                      @endforeach
                    @endif

                    <select class="js-example-basic-multiple w-100" name="masters[][user_id]" id="user_id" multiple="multiple">
                      @foreach($options['users'] as $key => $userName)
                        @if(old('masters'))
                          <option value="{{$key}}" {{ (is_array($oldmasters) && in_array($key, $oldmasters)) ? ' selected' : '' }}>{{$userName}}</option>
                        @else
                          <option value="{{$key}}" {{ auth()->user()->id == $key ? ' selected' : '' }}>{{$userName}}</option>
                        @endif

                      @endforeach
                    </select>

                    @error('masters')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>

                </div>

                <div class="col-12">
                  <label for="gemder" class="d-block">Treatment Date & Time <small class="text-danger">required</small></label>
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

                  <div class="form-group control-group increment before">
                    <label>Before Treat Upload</label>
                    <div class="custom-file before">
                        <input type="file" class="custom-file-input" name="filenamebefore[]" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                        <button class="btn btn-icon btn-success btn-before" type="button">
                        	<span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Add</span>
                        </button>
                    </div>
                  </div>


                  <div class="clone before d-none">
                    <div class="form-group control-group">
                      <div class="custom-file before">
                          <input type="file" class="custom-file-input" name="filenamebefore[]" lang="en">
                          <label class="custom-file-label" for="customFileLang">Select file</label>
                          <button class="btn btn-icon btn-danger" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                              <span class="btn-inner--text">Delete</span>
                          </button>
                      </div>
                    </div>
                  </div>


                  @error('filenamebefore')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>


                <div class="col-12 pt-3"><h3>Treatment</h3></div>

                <div class="col-12 pt-3">
                  <div class="row">
                    @foreach($options['drugs'] as $drug)
                    <div class="col-2">
                      {{ Form::hidden('drug['.$drug->id.'][drug_id]', $drug->id) }}
                      <div class="form-group">
                        {!! Form::select('drug['.$drug->id.'][quantity]', $options['OneTen'], null, array('class' => 'form-control', 'style' => 'height:34px; padding:0 .75rem;border: 2px solid '.$drug->color, 'id' => 'quantity')) !!}
                        @error('drug.*.quantity')
                        <small class="text-danger">{{ $message}}</small>
                        @enderror
                      </div>
                    </div>
                    <div class="col-2">
                      {{$drug->name}}
                    </div>
                    <div class="col-8">
                      @php
                        $olddrugparts = [];
                      @endphp
                      @if(old('drug.'.$drug->id.'.parts'))
                        @foreach(old('drug.'.$drug->id.'.parts') as $yy)
                          <?php
                            $olddrugparts[] = $yy['part_id'];
                          ?>
                        @endforeach
                      @endif

                      <select class="js-example-basic-multiple w-100" name="drug[{{$drug->id}}][parts][][part_id]" id="drugpart{{$drug->id}}" multiple="multiple">
                        @foreach($options['injuryparts'] as $key => $userName)
                            <option value="{{$key}}" {{ (is_array($olddrugparts) && in_array($key, $olddrugparts)) ? ' selected' : '' }}>{{$userName}}</option>
                        @endforeach
                      </select>
                    </div>
                    @endforeach
                  </div>
                </div>

                <div class="col-12 pt-3">
                  <div class="form-group">
                    {{-- <label for="address">Treatment <small class="text-danger">required</small></label> --}}
                    <textarea class="form-control" id="treatment" name="treat[treatment]" rows="3" placeholder="Enter Treatment: Adj Click">{{ old('treat.treatment') }}</textarea>
                    @error('treat.treatment')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">

                      <div class="col-6 col-md-3">
                        <input type="checkbox" name="treat[guasha]" class="custom-control-input" id="guasha" value="yes"  {{ old('treat.guasha') == 'yes' ? ' checked' : '' }}>
                        <label class="custom-control-label" for="guasha">GuaSha</label>
                      </div>

                      @error('treat.guasha')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
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

                <div class="col-12">
                  <div class="form-group control-group increment after">
                    <label>After Treat Upload</label>
                    <div class="custom-file after">
                        <input type="file" class="custom-file-input" name="filenameafter[]" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                        <button class="btn btn-icon btn-success btn-after" type="button">
                        	<span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Add</span>
                        </button>
                    </div>
                  </div>


                  <div class="clone after d-none">
                    <div class="form-group control-group">
                      <div class="custom-file after">
                          <input type="file" class="custom-file-input" name="filenameafter[]" lang="en">
                          <label class="custom-file-label" for="customFileLang">Select file</label>
                          <button class="btn btn-icon btn-danger" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                              <span class="btn-inner--text">Delete</span>
                          </button>
                      </div>
                    </div>
                  </div>


                  @error('filenameafter')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>


              </div>
              <hr />
              <h3>Treatment Fee</h3>
              <div class="table-responsive products">
                <div>
                  <table class="table align-items-center">
                    <tbody class="list">
                      <tr>
                        <td colspan="3" class="text-right">
                          Treatment Fee (RM)
                        </td>
                        <td class="">
                          <div class="form-group">
                            <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', '0') }}" />
                          </div>
                        </td>
                      </tr>

                      @can('reception-edit')
                      <tr>
                      @else
                      <tr class="producut-hide">
                      @endcan
                        <td colspan="3" class="text-right">
                          Total Fees (RM)
                        </td>
                        <td class="">
                          <div class="form-group">
                            <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', '0') }}" readonly />
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Memo</label>
                    <textarea class="form-control" id="memo" name="treat[memo]" rows="3" placeholder="Enter Remarks">{{ old('treat.memo') }}</textarea>
                    @error('treat.memo')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>
              </div>

              <h3>Appointment</h3>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="days" class="d-block">Next Treatment</label>
                    {!! Form::select('treat[days]', [null=>'Please Select'] + $options['days'], null, array('class' => 'form-control', 'id' => 'days')) !!}
                    @error('treat.days')
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

@push('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <style>
  .datepicker table tr td.today,  .datepicker table tr td.today:hover {
    background-color: #ccc;
  }

  .datetimepicker {
    background-color: #fff !important;
  }

  .table-responsive {
    overflow-y: hidden;
  }


  .producut-hide, .producut-hide td{
    visibility: hidden;
    display: block;
    height: 0;
  }

  </style>
@endpush

@push('js')


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
    enableTime: true,
    altInput: true,
    altFormat: "F j, Y H:i",
    dateFormat: "Y-m-d H:i",
    maxDate: new Date().fp_incr(1),
    minTime: "10:00",
    maxTime: "20:00",
    //defaultHour: "{{date('H')}}",
    //defaultMinute: "{{date('i')}}",
    //defaultDate: "2016-10-20"
    defaultDate: "{{date('Y-m-d H:i')}}"
  });

  $('.treat-fee').on('change blur',function(){
      if($(this).val().trim().length === 0){
        $(this).val({{ old('fee', '0') }});
      }
    });

  getvalues();

  $('.treat-fee').change(function(){
    getvalues();
  });

  function getvalues(){

       var fee = $('.treat-fee').val();

       var productsum = parseFloat(fee);

       $('.productsum').val(productsum);

  };

  $('.btn-before').click(function(){
    var html = $('.clone.before').html();
    $('.increment.before').after(html);
  });

  $('.btn-after').click(function(){
    var html = $('.clone.after').html();
    $('.increment.after').after(html);
  });

  $('body').on('click', '.btn-danger', function(){
    $(this).parents(".control-group").remove();
  });

  $("body").on('change', '.custom-file input', function (e) {
    if (e.target.files.length) {
      $(this).next('.custom-file-label').html(e.target.files[0].name);
    }
  });

});
</script>
@endpush
