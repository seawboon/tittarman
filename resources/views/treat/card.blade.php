<div class="card card-profile mb-3">

 <div class="card-body pt-0">
   <!--<div class="row">
     <div class="col">
       <div class="card-profile-stats d-flex justify-content-center">
         <div>
           <span class="heading">{{ count($patient->matters) }}</span>
           <span class="description">Cases</span>
         </div>
         <div>
           <span class="heading">0</span>
           <span class="description">Treatment</span>
         </div>

       </div>
     </div>
   </div>-->
   <div class="text-center pt-4">
     <h5 class="h3">
       <i>Injury Part</i><br />
       <span class="font-weight-light">{{ $matter->injury_part }}</span>
     </h5>
     <h5 class="h3">
       <i>Since</i><br />
       <span class="font-weight-light">{{ Carbon\Carbon::parse($matter->injury_since)->format('d M Y') }}</span>
     </h5>


     <h5 class="h3">
       <i>Remarks</i><br />
       <div class="h5 font-weight-300">
         <i class="ni location_pin mr-2"></i>{{ $matter->remarks ?? '' }}
       </div>
     </h5>

     <h5 class="h3">
       <i>Comments</i><br />
       <div class="h5 font-weight-300">
         <i class="ni location_pin mr-2"></i>{{ $matter->comments ?? '' }}
       </div>
     </h5>

     <h5 class="h3">
       <i>Type of Injury</i><br />
       <div class="h5 font-weight-300">
         <i class="ni location_pin mr-2"></i>
         @foreach($ii as $inj)
          <span class="badge badge-pill badge-primary m-1">{{ $inj->injury->name }}</span>
         @endforeach
       </div>
     </h5>

     @foreach($matter->images as $image)
     <span class="badge badge-md badge-circle badge-floating badge-default border-white" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ asset('storage/'.$image->filename) }}">
       {{$loop->iteration}}
     </span>
     @endforeach

     <hr class="my-4" />

     <a href="{{ route('matter.edit', ['patient'=> $patient, 'matter'=> $matter]) }}" class="btn btn-sm btn-default mb-3">Edit / View Case</a>

     <a href="{{ route('treat.index', ['patient'=> $patient, 'matter'=> $matter]) }}" class="btn btn-sm btn-success">View All Treatment</a>

   </div>
 </div>
</div>

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

@include('matter.card')
