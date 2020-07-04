@extends('layouts.app', ['titlePage' => $patient->fullname.' profile'])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
        <div class="container">
          <div class="card-body">

              <form action="{{ route('patient.update', $patient->id) }}" method="post">
                @csrf

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="title">Branch</label>
                      {!! Form::select('branch_id', $branches, $patient->branch_id, array('class' => 'form-control')) !!}
                      @error('salutation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="gemder" class="d-block">Gender</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="Male" value="male" {{ $patient->gender == 'male' ? 'checked' : ''}}>
                        <label class="form-check-label" for="Male">Male</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="Female" value="female" {{ $patient->gender == 'female' ? 'checked' : ''}}>
                        <label class="form-check-label" for="Female">Female</label>
                      </div>

                      @error('gender')
                      <small class="text-danger d-block">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <select class="form-control" id="salutation" name="salutation">
                        <option value="" selected="selected">Please Select</option>
                        <option value="Datuk Seri" {{($patient->salutation == 'Datuk Seri') ? 'selected' : ''}}>Datuk Seri</option>
                        <option value="Dato Sri" {{($patient->salutation == 'Dato Sri') ? 'selected' : ''}}>Dato Sri</option>
                        <option value="Datin Seri" {{($patient->salutation == 'Datin Seri') ? 'selected' : ''}}>Datin Seri</option>
                        <option value="Datuk" {{($patient->salutation == 'Datuk') ? 'selected' : ''}}>Datuk</option>
                        <option value="Dato" {{($patient->salutation == 'Dato') ? 'selected' : ''}}>Dato</option>
                        <option value="Datin" {{($patient->salutation == 'Datin') ? 'selected' : ''}}>Datin</option>
                        <option value="Dr" {{($patient->salutation == 'Dr') ? 'selected' : ''}}>Dr</option>
                        <option value="Mr" {{($patient->salutation == 'Mr') ? 'selected' : ''}}>Mr</option>
                        <option value="Mrs" {{($patient->salutation == 'Mrs') ? 'selected' : ''}}>Mrs</option>
                        <option value="Master" {{($patient->salutation == 'Master') ? 'selected' : ''}}>Master</option>
                        <option value="Miss" {{($patient->salutation == 'Miss') ? 'selected' : ''}}>Miss</option>
                        <option value="Prof" {{($patient->salutation == 'Prof') ? 'selected' : ''}}>Prof</option>
                        <option value="Puan Sri" {{($patient->salutation == 'Puan Sri') ? 'selected' : ''}}>Puan Sri</option>
                        <option value="Tan Sri" {{($patient->salutation == 'Tan Sri') ? 'selected' : ''}}>Tan Sri</option>
                      </select>
                      @error('salutation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-9">
                    <div class="form-group">
                      <label for="fullname">Name <small>as per NRIC / Passport</small></label>
                      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" value="{{ $patient->fullname }}">
                      @error('fullname')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <label for="gemder" class="d-block">Date of Birth</label>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Select date" type="text" id="dob" name="dob" value="{{ $patient->dob ?? '0000-00-00' }}">
                        </div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="nric">NRIC / Passport</label>
                      <input type="text" class="form-control" id="nric" name="nric" placeholder="Enter NRIC/Passport" value="{{ $patient->nric }}">
                      @error('nric')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $patient->email }}">
                      @error('email')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="contact">Contact</label>
                      <div class="row">
                        <div class="col-4">
                          <select class="form-control" id="provider" name="provider">
                            <option value="">Please Select</option>
                            <option value="010" {{($patient->provider == '010') ? 'selected' : ''}}>010</option>
                            <option value="011" {{($patient->provider == '011') ? 'selected' : ''}}>011</option>
                            <option value="012" {{($patient->provider == '012') ? 'selected' : ''}}>012</option>
                            <option value="013" {{($patient->provider == '013') ? 'selected' : ''}}>013</option>
                            <option value="014" {{($patient->provider == '014') ? 'selected' : ''}}>014</option>
                            <option value="016" {{($patient->provider == '016') ? 'selected' : ''}}>016</option>
                            <option value="017" {{($patient->provider == '017') ? 'selected' : ''}}>017</option>
                            <option value="018" {{($patient->provider == '018') ? 'selected' : ''}}>018</option>
                            <option value="019" {{($patient->provider == '019') ? 'selected' : ''}}>019</option>
                          </select>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" value="{{ $patient->contact }}">
                          @error('contact')
                          <small class="text-danger">{{ $message}}</small>
                          @enderror
                        </div>
                      </div>

                      @error('contact')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="occupation">Occupation</label>
                      <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Enter Occupation" value="{{ $patient->occupation }}">
                      @error('occupation')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="form-group">
                      <label for="sensitive_skin" class="d-block">Sensitive Skin</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sensitive_skin" id="ss_yes" value="yes" {{ $patient->sensitive_skin == 'yes' ? 'checked' : ''}} >
                        <label class="form-check-label" for="ss_yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sensitive_skin" id="ss_no" value="no" {{ $patient->sensitive_skin == 'no' ? 'checked' : ''}}>
                        <label class="form-check-label" for="ss_no">No</label>
                      </div>

                      @error('sensitive_skin')
                      <small class="text-danger d-block">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address2" name="address" placeholder="Enter Address" value="{{ $patient->address }}">
                      @error('address')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="" value="{{ $patient->address2 }}">
                      @error('address2')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="address">Postcode</label>
                      <input type="text" class="form-control" id="postcode" name="postcode" placeholder="" value="{{ $patient->postcode }}">
                      @error('postcode')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="address">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ $patient->city }}">
                      @error('city')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="state">State</label>
                      {!! Form::select('state', [null=>'Please Select'] + $states, $patient->state, array('class' => 'form-control')) !!}
                      @error('state')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="country">Country</label>
                      {!! Form::select('country', [null=>'Please Select'] + $countries, $patient->country , array('class' => 'form-control')) !!}
                      @error('country')
                      <small class="text-danger">{{ $message}}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">

                        <div class="col-6 col-md-3">
                          <input type="checkbox" name="freegift" class="custom-control-input" id="freegift" value="yes"  {{ $patient->freegift == 'yes' ? ' checked' : '' }}>
                          <label class="custom-control-label" for="freegift">Free Gift</label>
                        </div>

                        @error('freegift')
                        <small class="text-danger">{{ $message}}</small>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>


                <button type="submit" name="submit" value="save" class="btn btn-primary">Edit Patient</button>

                @can('master-edit')<button type="submit" name="submit" value="new-case" class="btn btn-primary">Edit & Add New Case</button>@endcan

              </form>
           </div>


           <hr />
            <div>
              <h3>Cases List @can('master-edit')<a class="btn btn-sm btn-info float-right" href="{{ route('matter.create', ['patient' => $patient]) }}">New Case</a>@endcan</h3>
              <div class="table-responsive mt-3">

                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-dark">
                                  <tr>
                                      <th scope="col" class="sort" data-sort="name">No.</th>
                                      <th scope="col" class="sort" data-sort="budget">Cases</th>
                                      <th scope="col" class="sort" data-sort="status">Injury Since</th>
                                      <th scope="col" colspan="2" class="sort" data-sort="branch">
                                        <div class="row">
                                          <div class="col-4">
                                            treatment
                                          </div>
                                          <div class="col-8">
                                            Photos
                                          </div>
                                        </div>
                                      </th>
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
                                        <td class="align-top">
                                            {{ Carbon\Carbon::parse($matter->injury_since)->format('d M Y') }}
                                        </td>
                                        <td colspan="2" class="align-top">
                                            @foreach($matter->treats as $treat)
                                            <div class="row mb-1">
                                              <div class="col-4">
                                                <a class="d-block mb-2 w-75" href="{{ route('treat.edit', ['patient' => $patient, 'matter' => $treat->matter_id, 'treat' => $treat]) }}">{{ Carbon\Carbon::parse($treat->treat_date)->format('d M Y') }}</a>
                                              </div>
                                              <div class="col-8">
                                                @foreach($treat->images as $image)
                                                @php
                                                  $badgeColor = 'badge-default';
                                                  if($image->state == 'after') {
                                                    $badgeColor = 'badge-info';
                                                  }
                                                @endphp
                                                <span class="badge badge-sm badge-circle badge-floating {{$badgeColor}} border-white" style="width:1.5rem; height:1.5rem" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ asset('storage/'.$image->filename) }}">
                                                  {{$loop->iteration}}
                                                </span>
                                                @endforeach
                                              </div>
                                            </div>

                                            @endforeach
                                        </td>


                                        <td class="align-top px-0">
                                          @can('master-create')<a data-toggle="tooltip" data-placement="left" title="New Treat" class="badge badge-md badge-circle badge-floating badge-default border-white" href="{{ route('treat.create', ['patient' => $patient, 'matter' => $matter])}}"><i class="ni ni-fat-add"></i></a>@endcan
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


@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" charset="utf-8"></script>


<script>
$(document).ready(function() {
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  $('.datepicker').datepicker({
    format: 'dd M yyyy',
  });
});
</script>
@endpush
