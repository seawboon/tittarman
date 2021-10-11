<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>
    <link type="text/css" href="http://tittarman.localhost.com/argon/css/argon.css?v=1.0.0" rel="stylesheet">
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
        <th colspan="4" class="text-capitalize text-left">
          <small class="d-block">Name :</small>
          <small>{{$package->patient->salutation}}</small> {{strtolower($package->patient->fullname)}}</h3>
        </th>
        <th colspan="1" class="text-capitalize text-left">
          <small class="d-block">ID :</small>
          {{ $package->patient->id }}
          @if($package->patient->accounts->isNotEmpty())
            |
            @foreach($package->patient->accounts as $account)
              {{ $account->branch->short}}-{{ $account->account_no}}
              @if(!$loop->last)
                 |
             @endif
            @endforeach
          @endif
        </th>
      </tr>

      <tr>
        <th colspan="5" style="padding:0;margin:0">
          <table width="100%" style="padding:0;margin:0">><tr>
            <th style="width:25%">
              <small class="d-block">Price :</small>
              RM 
              @if($package->package->id != 18)
                {{ $package->variant->sell }}
              @else
                {{ $package->alacarte['sell'] }}
              @endif
            </th>
            <th style="width:25%">
              <small class="d-block">Package :</small>
              {{ $package->package->title }}
            </th>
            <th style="width:25%">
              <small class="d-block">Variant :</small>
              {{ $package->variant->name }}
            </th>
            <th style="width:25%">
              <small class="d-block">Bought :</small>
              {{ $package->date }}
            </th>
          </tr></table>
        </th>

      </tr>

                <tr>
                  <th scope="col">#</th>
                  <th scope="col">CODE</th>
                  <th scope="col">CLAIM BY</th>
                  <th scope="col">DATE</th>
                  <th scope="col">EXPIRY DATE</th>
                </tr>
                @foreach($package->patientVouchers as $voucher)
                <tr>
                  <th>{{$loop->iteration}}</th>
                  <td>{{$voucher->code}}</td>
                  <td>{{($voucher->state == 'claimed') ? $voucher->claimBy->fullname : ''}}</td>
                  <td>{{($voucher->state == 'claimed') ? Carbon\Carbon::parse($voucher->updated_at)->format('d M Y') : ''}}</td>
                  <td>
                    <span id="voucher-{{$voucher->id}}-expiry">{{ Carbon\Carbon::parse($voucher->expired_date)->format('d M Y') }}</span>
                  </td>
                </tr>
                @endforeach

    </table>
</div>


</body>
</html>
