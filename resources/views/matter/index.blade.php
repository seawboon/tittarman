@extends('layouts.app', ['titlePage' => __(' CASES & TREATMENTS LIST')])

@section('content')

    <div class="header bg-gradient-Secondary py-6 py-lg-7 vh-100">
        <div class="container-fluid">
          <div class="row">


          {{--<div class="col-xl-4 order-xl-2">
           @include('matter.card')
          </div>--}}

        <div class="col-xl-12 order-xl-1">

          <h3><small>{{$patient->salutation}}</small> {{$patient->fullname}} <a class="btn btn-sm btn-info ml-2" href="{{ route('matter.create', ['patient' => $patient]) }}">New Case</a></h3>
          <div class="table-responsive mt-3">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Cases</th>
                                    <th scope="col" class="sort" data-sort="budget">Photos</th>
                                    <th scope="col" class="sort" data-sort="status">Injury Since</th>
                                    <th scope="col" class="sort" data-sort="branch">Treatment</th>
                                    <th scope="col" class="sort" data-sort="branch" style="width:40px !important; padding: .75rem 0"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($patient->matters as $matter)
                                <tr>
                                    <th scope="row" class="align-top">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget align-top">
                                      <a href="{{ route('matter.edit', ['patient' => $patient, 'matter' => $matter]) }}">
                                        @foreach($matter->parts as $part)
                                          {{$part->part->name}}@if(!$loop->last) + @endif
                                        @endforeach
                                      </a>
                                        <div>
                                          <i>{{ $matter->notes ?? '' }}</i>
                                        </div>
                                    </td>
                                    <td class="budget align-top">
                                        @if(count($matter->images) > 0)
                                          @foreach($matter->images as $image)
                                          <span class="badge badge-md badge-circle badge-floating badge-default border-white" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ asset('storage/'.$image->filename) }}">
                                            <i class="ni ni-album-2"></i>
                                          </span>
                                          @endforeach
                                        @endif
                                    </td>
                                    <td class="align-top">
                                        {{ Carbon\Carbon::parse($matter->injury_since)->format('d M Y') }}
                                    </td>
                                    <td class="align-top">
                                        @foreach($matter->treats as $treat)
                                          <a class="d-block mb-2 w-75" href="{{ route('treat.edit', ['patient' => $patient, 'matter' => $treat->matter_id, 'treat' => $treat]) }}">{{ Carbon\Carbon::parse($treat->treat_date)->format('d M Y') }}</a>
                                        @endforeach
                                        {{--<div class="col-auto">
                                          <a href="{{ route('treat.index', ['patient' => $patient, 'matter' => $matter]) }}" class="badge badge-md badge-circle badge-floating badge-default border-white">{{ count($matter->treats)}}</a>
                                        </div>

                                        <div>
                                          @if($matter->treats->last()['treat_date'])
                                          <a href="{{ route('treat.index', ['patient' => $patient, 'matter' => $matter->treats->sortBy('treat_date')->last()['matter_id']]) }}">
                                            {{ Carbon\Carbon::parse($matter->treats->sortBy('treat_date')->last()['treat_date'])->format('d M Y') }}<br />
                                            {{ Carbon\Carbon::parse($matter->treats->sortBy('treat_date')->last()['treat_date'])->format('g:i A') }}
                                          </a>
                                          @endif
                                        </div>
                                        --}}
                                    </td>
                                    <td class="align-top px-0">
                                      <a class="badge badge-md badge-circle badge-floating badge-default border-white" href="{{ route('treat.create', ['patient' => $patient, 'matter' => $matter])}}"><i class="ni ni-fat-add"></i></a>
                                      {{--<div class="dropdown float-right">
                                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                              <a class="dropdown-item" href="{{ route('matter.edit', ['patient' => $patient, 'matter' => $matter]) }}">View / Edit</a>
                                              <a class="dropdown-item" href="{{ route('treat.create', ['patient' => $patient, 'matter' => $matter])}}"> Add Treatment</a>
                                              <!--<a class="dropdown-item" href="#">View</a>
                                              <a class="dropdown-item" href="#">Something else here</a>-->
                                          </div>

                                      </div>
                                      --}}
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

@push('js')
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
@endpush
