@extends('layouts.app', ['titlePage' => 'Import Patient'])

@section('content')
    <div class="header bg-gradient-Secondary py-7 py-lg-8 vh-100">
        <div class="container">

          @if($errors->any())
          <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-lable="close">x</a>
            <ul>
                @foreach($errors->all() as $error)
                  <li>
                    {{ $error }}
                  </li>
                @endforeach
            </ul>
          </div>
          @endif

          @if($message = Session::get('success'))
          <div class="alert alert-success alert-block">
            <a href="#" class="close" data-dismiss="alert" aria-lable="close">x</a>
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>{{ $message }}</strong>
          </div>
          @endif

          <div class="card-body">
            <form action="{{ url('import-patient') }}" method="POST" name="importform" enctype="multipart/form-data">
              @csrf
              <input type="file" name="import_file" class="form-control">
              <br />
              <button class="btn btn-success">Import File</button>
            </form>
          </div>


        </div>
    </div>


@endsection
