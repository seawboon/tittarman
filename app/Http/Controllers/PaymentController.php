<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Branches;
use App\Patient;
use App\Matter;
use App\injury;
use App\MatterInjury;
use App\Treat;
use App\User;
use Spatie\Permission\Models\Role;
use App\Product;
use App\PaymentProduct;
use App\Images;
use App\Checkin;
use App\Payment;
use App\PaymentMethod;
use App\Voucher;
use Image;
use File;

use Session;

class PaymentController extends Controller
{
  private $days = [
    '2' => '2 Days',
    '3' => '3 Days',
    '4' => '4 Days',
    '5' => '5 Days',
    '6' => '6 Days',
    '7' => '1 Week',
    '14' => '2 Weeks',
    '30' => '1 Month',
  ];

  public function create(Patient $patient)
  {
      //dd($payment->treat);
      //$age = Carbon::parse($payment->patient->dob)->age;
      //$patient->load('vouchers');
      $products = Product::where('status', 'yes')->get();
      $vouchersFirst = Voucher::where('state', 'enable')->where('payment_id', null)->latest()->take(20)->get();
      $voucherslast = Voucher::where('state', 'enable')->where('payment_id', null)->oldest()->take(20)->get();
      $vouchers = $vouchersFirst->merge($voucherslast);
      $methods = PaymentMethod::where('status', 'yes')->pluck('name','id')->all();

      return view('payment.create', compact('patient','products', 'vouchers','methods'));
  }

  public function store(Patient $patient, Request $request)
  {
      //dd($request->all());
      $data = request()->validate([
        'product.*' => 'required',
        'voucher.*' => '',
        'treat.discount' => 'required',
        'treat.discount_code' => '',
        'treat.total' => 'required',
        'treat.method_id' => 'required',
      ]);

      $data['treat']['product_amount'] = $request->treat['total'] + $request->treat['discount'] - $request->treat['fee'];
      $data['treat']['state'] = 'paid';
      $data['treat'] = $request->treat['fee'];

      $vvE = 'yes';
      dd($data['voucher']);
      if(isset($data['voucher'])) {
        foreach ($data['voucher'] as $key => $voucher) {
          $lols = Voucher::where('code', $voucher['code'])->where('patient_id', null)->first();
          if($lols == null) {
            $vvE = 'no';
            Session::flash('message', 'Voucher invalid!');
            Session::flash('alert-class', 'alert-danger');
            break;
          }
        }
      }

      if($vvE == 'yes') {
        $payment = new Payment;
        $payment->patient_id = $patient->id;
        $payment->branch_id = session('myBranch')->id;
        $payment->treatment_fee = $request->treat['fee'];
        $payment->product_amount = $request->treat['total'] + $request->treat['discount'] - $request->treat['fee'];
        $payment->discount = $request->treat['discount'];
        $payment->method_id = $request->treat['method_id'];
        //$payment->discount_code = $request->treat['discount_code'];
        $payment->total = $request->treat['total'];
        $payment->state = 'paid';
        $payment->save();

        if(isset($data['voucher'])) {
          foreach ($data['voucher'] as $key => $voucher) {
            $uptV = Voucher::where('code', $voucher['code'])->where('patient_id', null)->first();
            $uptV->patient_id = $patient->id;
            $uptV->payment_id = $payment->id;
            $uptV->product_id = $voucher['product_id'];
            $uptV->save();
          }
        }

        PaymentProduct::where('payment_id', $payment->id)->delete();
        $payment->products()->createMany($data['product']);

        $payment->discount_code = $request->treat['discount_code'];
        if(!empty($payment->discount_code)) {
          $disCode = Voucher::where('code', $payment->discount_code)->where('patient_id', $payment->patient_id)->where('state', 'enable')->first();
          if($disCode == null) {
            Session::flash('message', 'Discount Code invalid!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('payment.create', $patient);
          } else {
            $payment->save();
            $disCode->state = 'claimed';
            $disCode->save();
          }
        }

        //$payment->save();



        return redirect()->route('checkin.index');

      } else {
        return redirect()->route('payment.create', $patient);
      }


  }

  public function edit(Payment $payment)
  {
      //dd($payment->treat);
      $age = Carbon::parse($payment->patient->dob)->age;
      $products = Product::where('status', 'yes')->get();
      //$role = Role::where('name', 'master')->first();
      //$users = $role->users()->pluck('name','id')->all();
      //$branches = Branches::pluck('name','id')->all();
      //$ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();
      $days = $this->days;
      //$vouchers = Voucher::where('state', 'enable')->where('payment_id', null)->get();
      $vouchers = Voucher::get();

      $voucherHasVoucher = Patient::has('AvailabelVoucher')->get();

      $voucherEd = collect($voucherHasVoucher);
      $voucherE = $voucherEd->firstWhere('id', $payment->patient->id);

      //push current patient to top
      if($voucherE!=null) {
        $bbid = $payment->patient->id;
        $voucherEd = $voucherEd->filter(function($item) use ($bbid) {
            return $item->id != $bbid;
        });
        $voucherEd->prepend($voucherE);
      }


      $methods = PaymentMethod::where('status', 'yes')->pluck('name','id')->all();

      //$treat->load('products');

      return view('payment.edit', compact('payment','products', 'days', 'vouchers', 'voucherEd', 'methods'));
  }

  public function update(Payment $payment, Request $request)
  {
      $data = request()->validate([
        'product.*' => '',
        'voucher.*' => '',
        'treat.discount' => 'required',
        'treat.discount_code' => '',
        'treat.total' => 'required',
        'treat.method_id' => 'required',
      ]);


      $data['treat']['product_amount'] = $data['treat']['total'] + $data['treat']['discount'] - $request->treat['fee'];
      $data['treat']['state'] = 'paid';
      //TreatProduct::where('treat_id', $treat->id)->delete();

      $vvE = 'yes';

      if(isset($data['voucher'])) {
        foreach ($data['voucher'] as $key => $voucher) {
          $lols = Voucher::where('code', $voucher['code'])->where('patient_id', null)->first();
          if($lols == null) {
            $vvE = 'no';
            Session::flash('message', 'Voucher invalid!');
            Session::flash('alert-class', 'alert-danger');
            break;
          }
        }
      }

      if($vvE == 'yes') {

        if(isset($data['voucher'])) {
          foreach ($data['voucher'] as $key => $voucher) {
            $uptV = Voucher::where('code', $voucher['code'])->where('patient_id', null)->first();
            $uptV->patient_id = $payment->patient->id;
            $uptV->payment_id = $payment->id;
            $uptV->product_id = $voucher['product_id'];
            $uptV->save();
          }
        }

        if($payment->discount_code=='' && $data['treat']['discount_code'] != '') {
          //$disCode = Voucher::where('code', $data['treat']['discount_code'])->where('patient_id', $payment->patient_id)->where('state', 'enable')->first();
          $disCode = Voucher::where('code', $data['treat']['discount_code'])->where('state', 'enable')->first();
          if($disCode == null) {
            Session::flash('message', 'Discount Code invalid!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('payment.edit', $payment);
          } else {
            if($disCode->patient_id == $payment->patient->id) {
              $disCode->state = 'claimed';
            } else {
              $disCode->state = 'claimed';
              if($disCode->owner_id == null) {
                $disCode->owner_id = $disCode->patient_id;
              }
              $disCode->transfer = 'yes';
              $disCode->transfer_date = now();
              $disCode->patient_id = $payment->patient->id;
              Session::flash('message', 'Voucher transfer from '.$payment->patient->fullname);
              Session::flash('alert-class', 'alert-success');
            }

            $disCode->save();
          }
        }

        $payment->update($data['treat']);
        PaymentProduct::where('payment_id', $payment->id)->delete();

        $payment->products()->createMany($data['product']);



        switch(request('submit')) {
          case 'save':
            return redirect()->route('checkin.index');
          break;

          case 'new-appointment':
            return redirect()->route('appointments.create', ['patient' => $payment->patient->id, 'matter' => $payment->matter->id]);
          break;
        }
      } else {
        return redirect()->route('payment.edit', $payment);
      }





      //return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
  }

}
