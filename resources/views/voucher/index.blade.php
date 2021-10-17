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
              <div class="table-responsive">
              <table class="table tm-sm table-bordered table-white">
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
                  <th scope="col">
                    <small class="d-block">Price :</small>
                    RM @if($package->ala_carte_sell)
                    {{$package->ala_carte_sell}}
                    @else
                      {{ $package->variant->sell }}
                    @endif
                  </th>
                  <th scope="col"><small class="d-block">Package :</small>
                  {{ $package->package->title }}</th>
                  <th scope="col"><small class="d-block">Variant :</small>
                  {{ $package->variant->name }}</th>
                  <th scope="col"><small class="d-block">Bought - Expiry Date :</small>
                  {{ $package->date }} - <span id="package-{{$package->id}}-expiry">{{ Carbon\Carbon::parse($package->patientVouchers->first()->expired_date)->format('d M Y') }} <i class="ni ni-settings text-pink btn-expiry" data-id="{{$package->id}}"></i></span>
                  <form class="form-inline" name="patient-package-{{$package->id}}" action="{{ route('voucher.patient.update', ['patient' => $patient]) }}" method="post">
                    @csrf
                    <div class="form-group" id="package-{{$package->id}}-input-wrp" style="display: none; width:68%">
                      <input type="text" name="package_voucher_expiry_date" class="form-control form-control-sm flatpickr datetimepicker" data-date-end-date="0d" data-date-today-highlight="true" value="{{ $package->patientVouchers->first()->expired_date ?? '0000-00-00' }}" id="package-voucher-{{$package->id}}-input">
                      <input type="hidden" name="package_id" value="{{$package->id}}">
                    </div>

                  </form>
                  </th>

                </tr>



                <tbody>
                  <tr>
                    <td colspan="5" class="p-0">
                      {{-- <form class="form-inline" name="patient-package-{{$package->id}}" action="{{ route('voucher.patient.update', ['patient' => $patient]) }}" method="post">
                        @csrf --}}
                      <table class="table table-sm table-bordered mb-0 bg-white table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">code</th>
                            <th scope="col">claim by</th>
                            <th scope="col">date</th>
                            <th scope="col">Branch</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($package->patientVouchers as $voucher)
                          <tr>
                            <th>{{$loop->iteration}}</th>
                            <td>
                              <span id="code-{{$voucher->id}}">{{$voucher->code}}@if($voucher->state != 'claimed')<i class="ni ni-settings text-pink btn-edit-voucher" data-id="{{$voucher->id}}"></i>@endif</span>
                              <form class="form-inline" name="voucher-code-{{$voucher->id}}" action="{{ route('single.code.update', ['code' => $voucher->id]) }}" method="post">
                                @csrf
                                <div class="form-group" id="voucher-code-{{$voucher->id}}-input-wrp" style="display: none; width:68%">
                                  <input type="text" name="voucher-code" class="form-control form-control-sm" value="{{ $voucher->code }}" id="voucher-code-{{$voucher->id}}-input">
                                </div>
                                <div>
                                  <button class="btn-sm btn-warning mt-2 chk-ava-code" id="voucher-code-{{$voucher->id}}-btn-check" data-id="{{$voucher->id}}" style="display:none">Check Code Availability</button>
                                  <span id="hidden-chkbox-{{$voucher->id}}" style="display:block;height:0"><input type="text" id="hchkbox-{{$voucher->id}}" required style="width:0; height:0;opacity: 0;"></span>
                                </div>
                                <button type="submit" id="btn-submit-{{$voucher->id}}" name="submit" value="save" class="btn-sm btn-primary" style="display:none">Edit Code</button>
                              </form>
                            </td>
                            <td>{{($voucher->state == 'claimed') ? $voucher->claimBy->fullname : ''}}</td>
                            <td>{{($voucher->state == 'claimed') ? Carbon\Carbon::parse($voucher->updated_at)->format('d M Y') : ''}}</td>
                            {{--<td>
                              <span id="voucher-{{$voucher->id}}-expiry">{{ Carbon\Carbon::parse($voucher->expired_date)->format('d M Y') }}</span>
                              <div class="form-group" id="voucher-{{$voucher->id}}-input-wrp" style="display:none; width:68%">
                                <input type="text" name="voucher[{{$loop->iteration}}][expiry]" class="form-control form-control-sm flatpickr datetimepicker" data-date-end-date="0d" data-date-today-highlight="true" value="{{ $voucher->expired_date ?? '0000-00-00' }}" id="voucher-{{$voucher->id}}-input">
                                <input type="hidden" name="voucher[{{$loop->iteration}}][id]" value="{{$voucher->id}}">
                              </div>
                              <i class="ni ni-settings text-pink btn-expiry" data-id="{{$voucher->id}}"></i>
                            </td>--}}
                            <td>
                                {{$voucher->useInPayment ? $voucher->useInPayment->treat->branch->short:''}}
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <div class="clearfix w-100">
                        <a class="btn btn-primary m-2 float-left" href="{{ route('package.pdf', $package) }}"  target="_blank">Print</a>
                        {{-- <button type="submit" name="submit" value="save" class="btn btn-danger m-2 float-right">Submit</button> --}}
                      </div>
                    {{-- </form> --}}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            {{-- <button id="btPrint" onclick="createPDF()" class="btn btn-primary btn-sm">TO PDF</button> --}}
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

    $(document).ready(function(){
      /*$(".btn-expiry").click(function(){
        var voucher_id = $(this).data("id");
        $("#voucher-"+voucher_id+"-expiry").hide();
        $("#voucher-"+voucher_id+"-input-wrp").css('display', 'inline-block');

      });*/

      $(".btn-expiry").click(function(){
        var voucher_id = $(this).data("id");
        $("#package-"+voucher_id+"-expiry").hide();
        $("#package-"+voucher_id+"-input-wrp").css('display', 'inline-block');

      });

      flatpickr('.datetimepicker', {
        enableTime: false,
        altInput: true,
        altFormat: "j M Y",
        dateFormat: "Y-m-d"
      });

      $(".btn-edit-voucher").click(function(){
        var code_id = $(this).data("id");
        $("#code-"+code_id).hide();
        $("#voucher-code-"+code_id+"-input-wrp, #voucher-code-"+code_id+"-btn-check, hidden-chkbox-"+code_id).css('display', 'inline-block');
        $("#voucher-code-"+code_id+"-btn-check").css('display', 'inline-block');
      });

      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $(".chk-ava-code").click(function(){
        var code_id = $(this).data("id");
        var newcode = $("#voucher-code-"+code_id+"-input").val();
        chkResult = ajaxChkCode(newcode);
        if(chkResult == 'yes') {
          $("#voucher-code-"+code_id+"-input").removeClass("alert-danger alert-success").addClass("alert-danger");
          $("#hchkbox-"+code_id).val('');
          $("#btn-submit-"+code_id).css('display', 'none');
        } else {
          $("#voucher-code-"+code_id+"-input").removeClass("alert-danger alert-success").addClass("alert-success");
          $("#hchkbox-"+code_id).val('ok');
          $("#btn-submit-"+code_id).css('display', 'inline-block');
        }
        return false;
      });

      function ajaxChkCode(code) {
        var result;
        $.ajax({
          async: false,
          url:"{{ route('checkCode') }}",
          type:"GET",
          data: {
          code: code
          },
          success:function (data) {
            console.log(data.status);
            result = data.status;
          }
        });

          return result;

      };

      function InvalidMsg(textbox) {

          if (textbox.value === '' || textbox.value!='ok') {
              textbox.setCustomValidity
                    ('Please Check Codes');
          } else if (textbox.validity.typeMismatch) {
              textbox.setCustomValidity
                    ('Please Check Codes');
          } else {
              textbox.setCustomValidity('');
          }

          return true;
      }


    });
</script>

@endpush
