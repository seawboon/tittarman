@extends('layouts.app', ['titlePage' => __(' Case')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('matter.card')
          </div>

        <div class="col-xl-8 order-xl-1">

          <form action="{{ route('matter.store', ['patient' => $patient->id]) }}" method="post">
            @csrf

            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label for="title">Injury Part</label>
                  <input type="text" class="form-control" id="injury_part" name="matter[injury_part]" value="{{ old('matter.injury_part') }}" placeholder="Enter injury part">
                  @error('matter.injury_part')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-6">
                <label for="gemder" class="d-block">Injury Since</label>
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control datepicker" data-date-end-date="0d" data-date-today-highlight="true" placeholder="Select date" type="text" id="injury_since" name="matter[injury_since]" value="{{ old('matter.injury_since') }}" autocomplete="off">

                    </div>
                    @error('matter.injury_since')
                    <small class="text-danger d-block">{{ $message}}</small>
                    @enderror
                </div>
              </div>



              <div class="col-12">
                <div class="form-group">
                  <label for="address">Remarks</label>
                  <textarea class="form-control" id="remarks" name="matter[remarks]" rows="3" placeholder="Enter Remarks">{{ old('matter.remarks') }}</textarea>
                  @error('matter.remarks')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>Type of Injury</label>
                  <div class="custom-control custom-checkbox">
                    <?php $oldinjuries = [];?>
                    @if(old('injuries'))

                      @foreach(old('injuries') as $xxx)
                        <?php
                          $oldinjuries[] = $xxx['injury_id'];
                        ?>
                      @endforeach
                    @endif


                    <div class="row">

                    @foreach($injuries as $injury)

                    <div class="col-6 col-md-3">
                      <input type="checkbox" name="injuries[][injury_id]" class="custom-control-input" id="injury-{{$injury->name}}" value="{{$injury->id}}"  {{ (is_array($oldinjuries) && in_array($injury->id, $oldinjuries)) ? ' checked' : '' }}>
                      <label class="custom-control-label" for="injury-{{$injury->name}}">{{$injury->name}}</label>
                    </div>

                    @endforeach

                    </div>
                    @error('injuries')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label for="address">Comments</label>
                  <textarea class="form-control" id="comments" name="matter[comments]" rows="3" placeholder="Enter Comments">{{ old('matter.comments') }}</textarea>
                  @error('matter.comments')
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


    @endsection

    @push('js')
    <style>
    .datepicker table tr td.today,  .datepicker table tr td.today:hover {
      background-color: #ccc;
    }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>


    <script>
    $(document).ready(function() {
      //$("input").attr("autocomplete", "off");
      $('.datepicker').datepicker({
        todayBtn:true,
      });
    });
    </script>
    @endpush
