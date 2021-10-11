@extends('layouts.app', ['class' => 'bg-default', 'titlePage' => __('Patients')])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
          <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success  alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form method="POST" action="{{ route('signaturepad.upload') }}">
                    @csrf
                    <div class="col-md-12">
                        <label class="" for="">Signature:</label>
                        <br/>
                        <div id="sig" ></div>
                        <br/>
                        <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                        <textarea id="signature64" name="signed" style="display: none"></textarea>
                    </div>
                    <br/>
                    <button class="btn btn-success">Save</button>
                </form>
           </div>

           <script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>

        </div>

    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
