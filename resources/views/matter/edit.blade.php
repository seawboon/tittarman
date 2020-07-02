@extends('layouts.app', ['titlePage' => __('Edit Case')])

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
                  <?php $mparts = [];?>
                  @if($parts->parts)

                    @foreach($parts->parts as $yy)
                      <?php
                        $mparts[] = $yy['injury_part_id'];
                      ?>
                    @endforeach
                  @endif
                  <select class="js-example-basic-multiple w-100" name="injury_parts[][injury_part_id]" multiple="multiple">
                    @foreach($injuryparts as $part)
                      <option value="{{$part->id}}" {{ (is_array($mparts) && in_array($part->id, $mparts)) ? ' selected' : '' }}>{{$part->name}}</option>
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
                  <textarea class="form-control" id="notes" name="matter[notes]" rows="2" placeholder="Enter Notes">{{ $matter->notes }}</textarea>
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




            </div>


            <button type="submit" name="submit" value="save" class="btn btn-primary">Edit Case</button>

            <button type="submit" name="submit" value="new-treat" class="btn btn-primary">Edit & Add New Treatment</button>

          </form>

          <hr />
          <h3>Treatment List <a class="btn btn-sm btn-info float-right" href="{{ route('treat.create', ['patient' => $patient, 'matter' => $matter]) }}">New Treatment</a></h3>
          <div class="table-responsive mt-3">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Date & Time</th>
                                    <th scope="col" class="sort" data-sort="status">Treatment</th>
                                    <th scope="col" class="sort" data-sort="budget">Photo</th>
                                    <th scope="col" class="sort" data-sort="branch">Treatment Fee</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($matter->treats as $treat)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td><a href="{{ route('treat.edit', ['patient' => $patient, 'matter' => $matter, 'treat' => $treat]) }}">
                                        {{ Carbon\Carbon::parse($treat->treat_date)->format('d M Y') }}
                                      </a><br />
                                      {{ $treat->branch->short }}
                                    </td>
                                    <td class="budget">
                                      By: {{ $treat->user->name }}<br />
                                        {{ $treat->treatment }}
                                        <i class="d-block">{{ $treat->remarks ?? '' }}</i>
                                    </td>
                                    <td>
                                      @foreach($treat->images as $image)
                                      <span class="badge badge-md badge-circle badge-floating badge-default border-white" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ asset('storage/'.$image->filename) }}">
                                        {{$loop->iteration}}
                                      </span>
                                      @endforeach
                                    </td>


                                    <td class="align-top">
                                        @money($treat->fee)
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
        </div>


        </div>


        </div>

        </div>

    </div>


    @endsection
    @push('css')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
      $('.js-example-basic-multiple').select2();

      $('.datepicker').datepicker({
        format: 'dd M yyyy',
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
