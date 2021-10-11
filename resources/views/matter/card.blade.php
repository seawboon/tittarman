<div class="card card-profile">

 <div class="card-body pt-0">
   <div class="row">
     <div class="col">
       <div class="card-profile-stats d-flex justify-content-center">
         <div>
           <span class="heading">{{ count($patient->matters) }}</span>
           <span class="description">Cases</span>
         </div>
         <div>
           <span class="heading">{{ count($patient->treats) }}</span>
           <span class="description">Treatment</span>
         </div>

       </div>
     </div>
   </div>
   <div class="text-center">
     <h5 class="h3">
       <small>{{ $patient->salutation ?? '' }} </small>{{ $patient->fullname }}<br /><span class="font-weight-light">{{ $patient->gender }}</span>
       @if($patient->dob)
       <span class="font-weight-light">, {{ Carbon\Carbon::parse($patient->dob)->age }}</span>
       @endif
     </h5>

     @if($patient->sensitive_skin == 'yes')
     <div class="h3 font-weight-300">
       <span class="badge badge-pill badge-warning">Sensitive Skin</span>
     </div>
     @endif

     <div class="h5 font-weight-300">
       <i class="ni location_pin mr-2"></i>{{ $patient->email ?? '' }}<br />{{ $patient->provider ?? '' }}{{ $patient->contact ?? '' }}
     </div>
     @if($patient->occupation)
     <div class="h5 mt-4">
       <i class="ni business_briefcase-24 mr-2"></i>{{ $patient->occupation }}
     </div>
     @endif
     <div>
       <i class="ni education_hat mr-2"></i>{{ $patient->branch->name }}
     </div>

     <hr class="my-4" />
     <a href="{{ route('matter.index', ['patient'=> $patient]) }}" class="btn btn-sm btn-info mb-3">{{ $patient->fullname}}'s Case(s)</a>

     <a href="{{ route('patient.edit', ['pid'=> $patient]) }}" class="btn btn-sm btn-primary">Edit / View {{ $patient->fullname}}'s Profile</a>

   </div>
 </div>
</div>
