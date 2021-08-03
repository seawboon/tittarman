@extends('layouts.app', ['titlePage' => __(' VOUCHER LIST')])

@section('content')

    <div class="header bg-gradient-Secondary py-6 py-lg-7 vh-100">
        <div class="container-fluid">
          <div class="row">

        <div class="col-xl-12 order-xl-1">

          {{-- <h3><small>{{$patient->salutation}}</small> {{$patient->fullname}}</h3> --}}

          <div class="row">

            @foreach($patient->packages as $package)
            <div class="col-6" id="tab">

              <table class="table table-bordered table-white">
                <tr>
                  <th colspan="5" class="text-capitalize">
                    <small class="d-block">Name :</small>
                    <small>{{$patient->salutation}}</small> {{strtolower($patient->fullname)}}</h3>
                  </th>
                </tr>

                <tr>
                  <th colspan="5">
                    <small class="d-block">Patient ID :</small>
                    {{ $patient->id }}&emsp;
                    @if($patient->accounts->isNotEmpty())
                      @foreach($patient->accounts as $account)
                        {{ $account->branch->short}}-{{ $account->account_no}}&emsp;
                      @endforeach
                    @endif
                  </th>
                </tr>

                <tr>
                  <th>
                    <small class="d-block">Package :</small>
                    {{ $package->package->title }}
                  </th>
                  <th colspan="2">
                    <small class="d-block">Variant :</small>
                    {{ $package->variant->name }}
                  </th>
                  <th colspan="2">
                    <small class="d-block">Bought :</small>
                    {{ $package->date }}
                  </th>
                </tr>



                <tbody>
                  <tr>
                    <td colspan="5" class="p-0">
                      <form class="form-inline" name="patient-package-{{$package->id}}" action="{{ route('voucher.patient.update', ['patient' => $patient]) }}" method="post">
                        @csrf
                      <table class="table table-bordered mb-0 bg-white">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">code</th>
                            <th scope="col">claim by</th>
                            <th scope="col">date</th>
                            <th scope="col">Expiry Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($package->patientVouchers as $voucher)
                          <tr>
                            <th>{{$loop->iteration}}</th>
                            <td>{{$voucher->code}}</td>
                            <td>{{($voucher->state == 'claimed') ? $voucher->claimBy->fullname : ''}}</td>
                            <td>{{($voucher->state == 'claimed') ? Carbon\Carbon::parse($voucher->updated_at)->format('d M Y') : ''}}</td>
                            <td>
                              <span id="voucher-{{$voucher->id}}-expiry">{{ Carbon\Carbon::parse($voucher->expired_date)->format('d M Y') }}</span>
                              <div class="form-group" id="voucher-{{$voucher->id}}-input-wrp" style="display:none; width:68%">
                                <input type="text" name="voucher[{{$loop->iteration}}][expiry]" class="form-control form-control-sm flatpickr datetimepicker" data-date-end-date="0d" data-date-today-highlight="true" value="{{ $voucher->expired_date ?? '0000-00-00' }}" id="voucher-{{$voucher->id}}-input">
                                <input type="hidden" name="voucher[{{$loop->iteration}}][id]" value="{{$voucher->id}}">
                              </div>
                              <i class="ni ni-settings text-pink btn-expiry" data-id="{{$voucher->id}}"></i>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <div class="clearfix w-100">
                        <button type="submit" name="submit" value="save" class="btn btn-primary m-2 float-right">Submit</button>
                      </div>
                    </form>
                    </td>
                  </tr>

                </tbody>
              </table>
              {{-- <button id="btPrint" onclick="createPDF()" class="btn btn-danger btn-sm">TO PDF</button> --}}
            </div>

            @endforeach
          </div>




        </div>

        <!-- transfers -->



        </div>

        </div>

    </div>



@endsection

@push('js')
<style>
.datetimepicker.input {
  width: 100% !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    /*function createPDF() {
        var sTable = document.getElementById('tab').innerHTML;

        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "</style>";

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head>');
        win.document.write('<title>Profile</title>');   // <title> FOR PDF HEADER.
        win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body></html>');

        win.document.close(); 	// CLOSE THE CURRENT WINDOW.

        win.print();    // PRINT THE CONTENTS.
    }*/


    $(document).ready(function(){
      $(".btn-expiry").click(function(){
        var voucher_id = $(this).data("id");
        $("#voucher-"+voucher_id+"-expiry").hide();
        $("#voucher-"+voucher_id+"-input-wrp").css('display', 'inline-block');

      });


      flatpickr('.datetimepicker', {
        enableTime: false,
        altInput: true,
        altFormat: "j M Y",
        dateFormat: "Y-m-d"
      });

    });
</script>

@endpush
