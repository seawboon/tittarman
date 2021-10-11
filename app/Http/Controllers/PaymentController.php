<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Branches;
use App\Patient;
use App\PatientVoucher;
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
use App\Package;
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

  public function index(Patient $patient)
  {
      $patient->load('payments.treat', 'payments.PatientPackage');
      return view('payment.index', compact('patient'));
  }

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
      $packages = Package::Published()->PublishedDate()->get();
      $packages->load('products.product');

      return view('payment.create', compact('patient','products', 'vouchers','methods', 'packages'));
  }

  public function store(Patient $patient, Request $request)
  {
      //dd($request->all());
      $data = request()->validate([
        'product.*' => 'required',
        'voucher.*' => '',
        'treat.discount' => 'required',
        /*'treat.discount_code' => '',*/
        'treat.total' => 'required',
        'treat.method_id' => 'required',
        'package.id' => '',
        'package.variant.id' => '',
        'package.voucher.*' => '',
        'alacart.*' => '',
      ]);

      $data['treat']['product_amount'] = $request->treat['total'] + $request->treat['discount'] - $request->treat['fee'];
      $data['treat']['state'] = 'paid';
      $data['treat'] = $request->treat['fee'];

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
        $payment = new Payment;
        $payment->patient_id = $patient->id;
        $payment->branch_id = isset(session('myBranch')->id) ? session('myBranch')->id : 0;
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

        /*$payment->discount_code = $request->treat['discount_code'];
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
        }*/

        //$alacarte = json_encode($data['alacart']);
        if(!is_null($data['package']['id']) && !is_null($data['package']['variant']['id'])) {
          $package = $payment->PatientPackage()->create([
              'patient_id' => $payment->patient_id,
              'payment_id' => $payment->id,
              'package_id' => $data['package']['id'],
              'variant_id' => $data['package']['variant']['id'],
              'alacarte' => json_encode($data['alacart']),
          ]);

          foreach ($data['package']['voucher'] as $key => $voucher) {
            //dd($voucher['voucher_type_id']);
            if($package->id != 18) {
              $setExpired_date = Carbon::now()->addMonths($package->variant->expiry);
            } else {
              $setExpired_date = Carbon::now()->addMonths($data['alacart']['expiry']);
            }

            $package->patientVouchers()->create([
              'patient_package_id' => $package->id,
              'patient_id' => $payment->patient_id,
              'voucher_type_id' => $voucher['voucher_type_id'],
              'variant_id' => $data['package']['variant']['id'],
              'code' => $voucher['code'],
              'expired_date' => $setExpired_date,
              'state' => 'enable',
            ]);
          }

          //dd($package->load('patientVouchers'));
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
      $payment->load('PatientPackage');
      if($payment->PatientPackage) {
        $payment->PatientPackage->alacarte = json_decode($payment->PatientPackage->alacarte);
      }
      $packages = Package::Published()->PublishedDate()->get();
      $packages->load('products.product');
      $age = Carbon::parse($payment->patient->dob)->age;
      $products = Product::where('status', 'yes')->get();
      //$role = Role::where('name', 'master')->first();
      //$users = $role->users()->pluck('name','id')->all();
      //$branches = Branches::pluck('name','id')->all();
      //$ii = MatterInjury::with('injury')->where('matter_id', $matter->id)->get();
      $days = $this->days;
      //$vouchers = Voucher::where('state', 'enable')->where('payment_id', null)->get();
      //$vouchers = Voucher::get();
      //$vouchersFirst = Voucher::where('state', 'enable')->where('payment_id', null)->latest()->take(20)->get();
      //$voucherslast = Voucher::where('state', 'enable')->where('payment_id', null)->oldest()->take(20)->get();
      //$vouchers = $vouchersFirst->merge($voucherslast);

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

      return view('payment.edit', compact('payment','products', 'days', 'packages', 'voucherEd', 'methods'));
  }

  public function editOld(Payment $payment)
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
      //$vouchers = Voucher::get();
      $vouchersFirst = Voucher::where('state', 'enable')->where('payment_id', null)->latest()->take(20)->get();
      $voucherslast = Voucher::where('state', 'enable')->where('payment_id', null)->oldest()->take(20)->get();
      $vouchers = $vouchersFirst->merge($voucherslast);

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

      return view('payment.edit-20210528', compact('payment','products', 'days', 'vouchers', 'voucherEd', 'methods'));
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
        'package.id' => '',
        'package.variant.id' => '',
        'package.voucher.*' => '',
        'alacart.*' => '',
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
            //$uptV->save();
          }
        }

        if($payment->discount_code=='' && $data['treat']['discount_code'] != '') {
          //$disCode = Voucher::where('code', $data['treat']['discount_code'])->where('patient_id', $payment->patient_id)->where('state', 'enable')->first();
          $disCode = PatientVoucher::where('code', $data['treat']['discount_code'])->where('state', 'enable')->first();
          if($disCode == null) {
            Session::flash('message', 'Discount Code invalid!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('payment.edit', $payment);
          } else {
            /*if($disCode->patient_id == $payment->patient->id) {
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
            }*/

            $disCode->state = 'claimed';
            $disCode->claim_by = $payment->patient->id;
            $disCode->use_in_payment = $payment->id;
            $disCode->save();
          }
        }

        $payment->update($data['treat']);
        PaymentProduct::where('payment_id', $payment->id)->delete();

        //$payment->products()->createMany($data['product']);
        //dd($data['package']['voucher']);

        if(isset($data['package']['id']) && isset($data['package']['variant']['id']) && !is_null($data['package']['id']) && !is_null($data['package']['variant']['id'])) {
          $package = $payment->PatientPackage()->create([
              'patient_id' => $payment->patient_id,
              'payment_id' => $payment->id,
              'package_id' => $data['package']['id'],
              'variant_id' => $data['package']['variant']['id'],
              'alacarte' => json_encode($data['alacart']),
          ]);

          foreach ($data['package']['voucher'] as $key => $voucher) {
            //dd($voucher['voucher_type_id']);
            if($package->id != 18) {
              $setExpired_date = Carbon::now()->addMonths($package->variant->expiry);
            } else {
              $setExpired_date = Carbon::now()->addMonths($data['alacart']['expiry']);
            }

            $package->patientVouchers()->create([
              'patient_package_id' => $package->id,
              'patient_id' => $payment->patient_id,
              'variant_id' => $data['package']['variant']['id'],
              'voucher_type_id' => $voucher['voucher_type_id'],
              'code' => $voucher['code'],
              'expired_date' => $setExpired_date,
              'state' => 'enable',
            ]);
          }

          //dd($package->load('patientVouchers'));
        }


        switch(request('submit')) {
          case 'save':

            return redirect()->route('payment.index', ['patient' => $payment->patient->id]);
            //return redirect()->route('checkin.index');
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
