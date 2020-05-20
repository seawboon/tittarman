@extends('layouts.app', ['titlePage' => __(' Case')])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('matter.card')
          </div>

        <div class="col-xl-8 order-xl-1">

          <form action="{{ route('matter.update', ['matter' => $matter, 'patient' => $patient]) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label for="title">Injury Part</label>
                  <input type="text" class="form-control" id="injury_part" name="matter[injury_part]" value="{{ $matter->injury_part }}" placeholder="Enter injury part">
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
                        <input class="form-control datepicker" data-date-end-date="0d" data-date-today-highlight="true" placeholder="Select date" type="text" id="injury_since" name="matter[injury_since]" value="{{ $matter->injury_since }}">

                    </div>
                    @error('matter.injury_since')
                    <small class="text-danger d-block">{{ $message}}</small>
                    @enderror
                </div>
              </div>



              <div class="col-12">
                <div class="form-group">
                  <label for="address">Remarks</label>
                  <textarea class="form-control" id="remarks" name="matter[remarks]" rows="3" placeholder="Enter Remarks">{{ $matter->remarks }}</textarea>
                  @error('matter.remarks')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>Type of Injury</label>
                  <div class="custom-control custom-checkbox">

                    <?php $minjuires = [];?>
                    @if($matter_injuries->injuries)

                      @foreach($matter_injuries->injuries as $xxx)
                        <?php
                          $minjuires[] = $xxx['injury_id'];
                        ?>
                      @endforeach
                    @endif

                    <div class="row">

                    @foreach($injuries as $injury)

                    <div class="col-6 col-md-3">
                      <input type="checkbox" name="injuries[][injury_id]" class="custom-control-input" id="injury-{{$injury->name}}" value="{{$injury->id}}"  {{ (is_array($minjuires) && in_array($injury->id, $minjuires)) ? ' checked' : '' }}>
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
                  <textarea class="form-control" id="comments" name="matter[comments]" rows="3" placeholder="Enter Comments">{{ $matter->comments }}</textarea>
                  @error('matter.comments')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group control-group increment">
                  <label>Upload</label>

                  <div>
                    @foreach($matter->images as $image)
                    <span class="badge badge-md badge-circle badge-floating badge-default border-white" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ asset('/image/'.$image->filename) }}">
                      {{$loop->iteration}}
                    </span>
                    @endforeach
                  </div>

                  <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFileLang" name="filename[]" lang="en">
                      <label class="custom-file-label" for="customFileLang">Select file</label>
                  </div>
                  <button class="btn btn-icon btn-success" type="button">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                      <span class="btn-inner--text">Add</span>
                  </button>
                </div>


                <div class="clone d-none">
                  <div class="form-group control-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="filename[]" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                        <button class="btn btn-icon btn-danger" type="button">
                          <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                            <span class="btn-inner--text">Delete</span>
                        </button>
                    </div>
                  </div>
                </div>


                @error('filename')
                <small class="text-danger">{{ $message}}</small>
                @enderror
              </div>


            </div>


            <button type="submit" name="submit" value="save" class="btn btn-primary">Edit Case</button>

            <button type="submit" name="submit" value="new-treat" class="btn btn-primary">Edit & Add New Treatment</button>

          </form>


        </div>


        </div>

        </div>

    </div>


    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

     <div class="modal-body">
       <img class="modalimage w-100" src="" />
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
    </div>
    </div>
    </div>

    <script>
    $(function(){
      $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(recipient);
        modal.find('.modalimage').attr('src', recipient);
      });
    });
    </script>

    <script>
    $(document).ready(function() {
      $('.datepicker').datepicker({});

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
