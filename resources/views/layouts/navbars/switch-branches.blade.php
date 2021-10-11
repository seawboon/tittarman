@if(Session::get('myBranch'))
  {{--
  <div class="text-center">
    <small class="text-center">{{ Session::get('myBranch')->name }}</small>
  </div>
  --}}

  <small class="d-block text-center">
    @php
      $SwBranche = App\Branches::all()->whereNotIn('id', [session('myBranch')->id]);
      $chBranches = App\Branches::pluck('name','id')->all();
    @endphp
    <i class="ni ni-square-pin text-pink"></i> Switch to
    {!! Form::select('choose-branch', $chBranches, session('myBranch')->id, array('class' => 'form-control form-control-sm', 'id' => 'choose-branch')) !!}
    {{--
    @if(Session::get('myBranch')->id == 2)
        <a class="nav-link" href="{{ route('checkin.setSession', ['branch' => 1])}}">
            <i class="ni ni-square-pin text-pink"></i> Switch to Mid Valley Megamall
        </a>
    @else
        <a class="nav-link" href="{{ route('checkin.setSession', ['branch' => 2])}}">
            <i class="ni ni-square-pin text-pink"></i> Switch to Plaza Arkadia
        </a>
    @endif
    --}}
  </small>
@endif
