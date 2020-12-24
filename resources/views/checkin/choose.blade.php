@extends('layouts.app', ['titlePage' => __('Check-in Branch')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">
          <div class="table-responsive">

            <div class="pl-4">

              <h2>I'm in Branch</h2>

              @foreach($branches as $branch)
                <a class="btn btn-sm btn-info ml-2" href="{{ route('checkin.setSession', ['branch' => $branch->id])}}">{{$branch->name}}</a>
              @endforeach
            </div>

</div>

<!--
<div class="text-center">
  <a href="{{ route('patient.create') }}" class="btn btn-sm btn-primary">Add New Patient</a>
</div>
-->
        </div>

    </div>


@endsection
