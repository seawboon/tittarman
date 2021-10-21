<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{str_replace(' ', '-', strtolower($package->patient->fullname))}}_{{ str_replace(' ', '-',$package->variant->name) }}_{{Carbon\Carbon::now()->format('d-M-Y')}}</title>
    <link type="text/css" href="http://tittarman.localhost.com/argon/css/argon.css?v=1.0.0" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #60A7A6;
            color: #FFF;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
    </style>

</head>
<body>

<div class="invoice">
    <table class="table table-bordered table-white" style="width:80%; margin-left:auto;margin-right:auto">

      <tr>
        <th colspan="5" style="padding:0;margin:0">
          <table width="100%" style="padding:0;margin:0">><tr>
            <th style="width:60%" class="text-capitalize">
              <small class="d-block">Name :</small>
              <small>{{$package->patient->salutation}}</small> {{strtolower($package->patient->fullname)}}</h3>
            </th>
            <th style="width:40%">
              <small class="d-block">ID :</small>
              {{ $package->patient->id }}
              @if($package->patient->accounts->isNotEmpty())

                @foreach($package->patient->accounts as $account)
                  @if($account->account_no)
                    {{ $account->branch->short}} - {{$account->account_no}}
                  @else
                    @if(!$loop->last)
                       &nbsp;&nbsp;|&nbsp;&nbsp;
                    @endif
                  @endif

                @endforeach
              @endif
            </th>
          </tr></table>
        </th>

      </tr>

      <tr>
        <th colspan="5" style="padding:0;margin:0">
          <table width="100%" style="padding:0;margin:0">><tr>
            <th style="width:22.5%">
              <small class="d-block">Price :</small>
              RM
              @if($package->package->id != 18)
                {{ $package->variant->sell }}
              @else
                {{ $package->alacarte['sell'] }}
              @endif
            </th>
            <th style="width:22.5%">
              <small class="d-block">Package :</small>
              {{ $package->package->title }}
            </th>
            <th style="width:22.5%">
              <small class="d-block">Variant :</small>
              {{ $package->variant->name }}
            </th>
            <th style="width:32.5%">
              <small class="d-block">Bought - Expiry Date :</small>
              {{ $package->date }} - {{ Carbon\Carbon::parse($package->patientVouchers->first()->expired_date)->format('d M Y') }}
            </th>
          </tr></table>
        </th>

      </tr>

                <tr>
                  <th scope="col" style="width:10px!important">#</th>
                  <th scope="col" style="width:90px!important">CODE</th>
                  <th scope="col">CLAIM BY</th>
                  <th scope="col" style="width:80px!important">DATE</th>
                  <th scope="col" style="width:50px!important">Branch</th>
                </tr>
                @foreach($package->patientVouchers as $voucher)
                <tr>
                  <th>{{$loop->iteration}}</th>
                  <td>{{$voucher->code}}</td>
                  <td>{{($voucher->state == 'claimed') ? $voucher->claimBy->fullname : ''}}</td>
                  <td>{{($voucher->state == 'claimed') ? Carbon\Carbon::parse($voucher->updated_at)->format('d M Y') : ''}}</td>
                  <td>
                    {{$voucher->useInPayment ? $voucher->useInPayment->treat->branch->short:''}}
                  </td>
                </tr>
                @endforeach

    </table>
</div>


</body>
</html>
