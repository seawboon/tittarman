@extends('layouts.app', ['titlePage' => __('Check-in')])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">

          <h3>Waiting List</h3>

          @include('checkin.awaiting')



<h3 class="mt-3">Treated List</h3>

  @include('checkin.treated')

<!--
<div class="text-center">
  <a href="{{ route('patient.create') }}" class="btn btn-sm btn-primary">Add New Patient</a>
</div>
-->
    </div>

</div>


@endsection
