@extends('layouts.app', ['titlePage' => __(' Case')])

@section('content')

    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container-fluid">
          <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('matter.card')
          </div>

        <div class="col-xl-8 order-xl-1">
          <div class="table-responsive">

                    <div>
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No.</th>
                                    <th scope="col" class="sort" data-sort="budget">Injury Part</th>
                                    <th scope="col" class="sort" data-sort="status">Injury Since</th>
                                    <th scope="col" class="sort" data-sort="branch">Treatment</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($patient->matters as $matter)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ $matter->injury_part }}
                                        <div>
                                          <i>{{ $matter->remarks ?? '' }}</i>
                                        </div>
                                        @if(count($matter->images) > 0)
                                          @foreach($matter->images as $image)
                                          <span class="badge badge-md badge-circle badge-floating badge-default border-white" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ asset('storage/'.$image->filename) }}">
                                            <i class="ni ni-album-2"></i>
                                          </span>
                                          @endforeach
                                        @endif

                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($matter->injury_since)->format('d M Y') }}
                                    </td>
                                    <td>
                                      <div class="row">
                                        <div class="col-auto">
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
                                      </div>





                                        <div class="dropdown float-right">
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
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
        </div>

        <div class="text-center">
          <a href="{{ route('matter.create', ['patient' => $patient]) }}" class="btn btn-sm btn-info">Add New Case</a>
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
