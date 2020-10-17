@extends('layouts.app', ['titlePage' => __('New Case')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('matter.card')
          </div>

        <div class="col-xl-8 order-xl-1">

          <form action="{{ route('matter.store', ['patient' => $patient->id]) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label for="title">Injury Part</label>
                  <?php $oldinjuryparts = [];?>
                  @if(old('injury_parts'))

                    @foreach(old('injury_parts') as $yy)
                      <?php
                        $oldinjuryparts[] = $yy['injury_part_id'];
                      ?>
                    @endforeach
                  @endif

                  <select class="js-example-basic-multiple w-100" name="injury_parts[][injury_part_id]" multiple="multiple">
                    @foreach($injuryparts as $part)
                      <option value="{{$part->id}}" {{ (is_array($oldinjuryparts) && in_array($part->id, $oldinjuryparts)) ? ' selected' : '' }}>{{$part->name}}</option>
                    @endforeach
                  </select>

                  @error('injury_parts')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label for="address">Notes</label>
                  <textarea class="form-control" id="notes" name="matter[notes]" rows="2" placeholder="Enter Notes">{{ old('matter.notes') }}</textarea>
                  @error('matter.notes')
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
                  <textarea class="form-control" id="remarks" name="matter[remarks]" rows="2" placeholder="Enter Remarks">{{ old('matter.remarks') }}</textarea>
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

                    @if($injury->id == 9)
                      <div class="col-6 col-md-3">
                        <input type="checkbox" name="injuries[][injury_id]" class="custom-control-input" id="injury-{{$injury->name}}" value="{{$injury->id}}"  {{ (is_array($oldinjuries) && in_array($injury->id, $oldinjuries)) ? ' checked' : '' }}>
                        <label class="custom-control-label" for="injury-{{$injury->name}}">{{$injury->name}}</label>
                      </div>
                      <div class="col-6 col-md-3 pl-0 pt-1">
                        <input type="text" id="other" name="matter[other]" class="form-control" placeholder="Other" value="{{ old('matter.other') }}" style="height:30px;margin-left: -13px;">
                      </div>
                    @else
                      <div class="col-6 col-md-3">
                        <input type="checkbox" name="injuries[][injury_id]" class="custom-control-input" id="injury-{{$injury->name}}" value="{{$injury->id}}"  {{ (is_array($oldinjuries) && in_array($injury->id, $oldinjuries)) ? ' checked' : '' }}>
                        <label class="custom-control-label" for="injury-{{$injury->name}}">{{$injury->name}}</label>
                      </div>
                    @endif



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

    @push('css')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('js')
    <style>
    .datepicker table tr td.today,  .datepicker table tr td.today:hover {
      background-color: #ccc;
    }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
      //$("input").attr("autocomplete", "off");
      $('.js-example-basic-multiple').select2();

      $('.datepicker').datepicker({
        format: 'dd M yyyy',
        todayBtn:true,
      });

      $('.btn-success').click(function(){
        var html = $('.clone').html();
        $('.increment').after(html);
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
