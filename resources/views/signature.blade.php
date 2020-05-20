@extends('layouts.app-signaturepad', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
        <div class="jumbotron">

          <h1 class="display-6">Signature pad library</h1>
          <p class="lead">Simple form made with Laravel framework and Ajax POST method s s</p>

          <div class="alert alert-success" style="display:none"></div>

            <div class="wrapper">
              <img src="https://preview.ibb.co/jnW4Qz/Grumpy_Cat_920x584.jpg" width=400 height=200 />
              <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
            </div>

            <br>
            <button class="btn btn-primary" id="save">Save</button>
            <button class="btn btn-primary" id="undo">Undo</button>
            <button class="btn btn-secondary" id="clear">Clear</button>

          </div>
      </div>

    </div>

    <div class="container mt--10 pb-5"></div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
