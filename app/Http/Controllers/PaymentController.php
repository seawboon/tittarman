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
use App\PaymentDiscount;
use App\PaymentCollection;
use App\Images;
use App\Checkin;
use App\Payment;
use App\PaymentMethod;
use App\Voucher;
use App\Package;
use App\ShopPromotion;
use Image;
use File;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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
      $patient->load('paymentsDesc.treat', 'paymentsDesc.PatientPackage');
      return view('payment.index', compact('patient'));
  }

  public function create(Patient $patient)
  {
      //dd($payment->treat);
      //$age = Carbon::parse($payment->patient->dob)->age;
      //$patient->load('vouchers');
      $products = Product::where('status', 'yes')->get();
      //$vouchersFirst = Voucher::where('state', 'enable')->where('payment_id', null)->latest()->take(20)->get();
      //$voucherslast = Voucher::where('state', 'enable')->where('payment_id', null)->oldest()->take(20)->get();
      //$vouchers = $vouchersFirst->merge($voucherslast);
      $methods = PaymentMethod::where('status', 'yes')->pluck('name','id')->all();
      $packages = Package::Published()->PublishedDate()->get();
      $packages->load('products.product');
      $promotions = ShopPromotion::pluck('name','id')->all();

      return view('payment.create', compact('patient','products','methods', 'packages', 'promotions'));
  }

  public function store(Patient $patient, Request $request)
  {
      //dd($request->all());
      $data = request()->validate([
        'product.*' => '',
        'voucher.*' => '',
        'treat.total' => 'required',
        'treat.paid_amount' => 'required',
        'treat.paid_date' => '',
        'treat.method_id' => 'required',
        'package.id' => '',
        'package.variant.id' => '',
        'package.voucher.*' => '',
        'alacart.*' => '',
      ]);
      $data['treat']['paid_date'] = null;

      $payment = new Payment;
      $payment->patient_id = $patient->id;
      $payment->branch_id = isset(session('myBranch')->id) ? session('myBranch')->id : 0;
      $payment->treatment_fee = $request->treat['fee'];
      $payment->method_id = $request->treat['method_id'];
      $payment->total = $request->treat['total'];
      $payment->save();

      if($request->payment_date != null) {
        $payment->created_at = date('Y-m-d H:i:s', strtotime($request->payment_date));
        $data['treat']['paid_date'] = $payment->created_at;
        $payment->save();
      }

      $this->updatePromotion($payment, $request->promotion_id, $request->promotion_amount, $request->promotion_code);

      $payment->product_amount = $request->variantValue + $this->updatePaymentProducts($payment, $data['product']);
      $payment->state = $this->updatePaymentCollection($payment, $data['treat']);
      $payment->discount = $payment->discounts->sum('discount_amount');
      $updateTreat = $data['treat'];
      $updateTreat = Arr::except($updateTreat, ['paid_amount', 'paid_date ']);
      $payment->save($updateTreat);

      if(!is_null($data['package']['id']) && !is_null($data['package']['variant']['id'])) {
        $package = $payment->PatientPackage()->updateOrCreate(
          [
            'patient_id' => $payment->patient_id,
            'payment_id' => $payment->id,

          ],
          [
            'package_id' => $data['package']['id'],
            'variant_id' => $data['package']['variant']['id'],
            'alacarte' => json_encode($data['alacart'])
          ]
        );

        $this->createVouchers($package, $data['package']['variant']['id'], $payment->patient_id, $data['package']['voucher'], $data['alacart']['expiry']);

      }

      return redirect()->route('payment.index', ['patient' => $payment->patient_id]);
      //return redirect()->route('checkin.index');

  }

  public function edit(Payment $payment, Request $request)
  {
    /*$collection = new PaymentCollection;
    $collection->amount = 30;
    $collection->payment_method_id = 1;
    $payment->collections()->save($collection);*/



      $payment->load('PatientPackage');
      if($payment->PatientPackage) {
        $payment->PatientPackage->alacarte = json_decode($payment->PatientPackage->alacarte);
      }
      $packages = Package::Published()->PublishedDate()->get();
      $packages->load('products.product');
      $age = Carbon::parse($payment->patient->dob)->age;
      $products = Product::where('status', 'yes')->get();
      $days = $this->days;

      $methods = PaymentMethod::where('status', 'yes')->pluck('name','id')->all();
      $promotions = ShopPromotion::pluck('name','id')->all();
      $customerVouchers = $payment->patient->AvailabelVoucher;

      if($request->searchName) {
        $customer = Patient::with('AvailabelVoucher.type')->where('fullname', $request->searchName)->first();
        if($customer) {
          $customerVouchers = $customer->AvailabelVoucher;
        }
      }

      if($request->searchContact) {
        $customer = Patient::with('AvailabelVoucher.type')->where('phone', $request->searchContact)->first();
        if($customer) {
          $customerVouchers = $customer->AvailabelVoucher;
        }
      }

      if($request->searchNRIC) {
        $customer = Patient::with('AvailabelVoucher.type')->where('nric', $request->searchNRIC)->first();
        if($customer) {
          $customerVouchers = $customer->AvailabelVoucher;
        }
      }

      return view('payment.edit', compact('payment','products', 'days', 'packages', 'methods','promotions', 'customerVouchers'));
  }

  public function update(Payment $payment, Request $request)
  {
      //dd($request->all());
      $data = request()->validate([
        'product.*' => '',
        'voucher.*' => '',
        //'treat.discount' => 'required',
        //'treat.discount_code' => '',
        'treat.total' => 'required',
        'treat.paid_amount' => 'required',
        'treat.paid_date' => '',
        'treat.method_id' => 'required',
        'package.id' => '',
        'package.variant.id' => '',
        'package.voucher.*' => '',
        'alacart.*' => '',
      ]);

      $vvE = $this->chkRedeemCode('update', $request->redeem_code, $payment);

      if($vvE === 'yes') {

        $data['treat']['state'] = $this->updatePaymentCollection($payment, $data['treat']);
        $data['treat']['product_amount'] = $request->variantValue + $this->updatePaymentProducts($payment, $data['product']);
        $this->updatePatientVoucher($request->redeem_code, $payment->patient->id, $payment);
        $this->updatePromotion($payment, $request->promotion_id, $request->promotion_amount, $request->promotion_code);
        $data['treat']['discount'] = $payment->discounts->sum('discount_amount');
        $updateTreat = $data['treat'];
        $updateTreat = Arr::except($updateTreat, ['paid_amount', 'paid_date']);
        $payment->update($updateTreat);

        if(isset($data['package']['id']) && isset($data['package']['variant']['id']) && !is_null($data['package']['id']) && !is_null($data['package']['variant']['id'])) {
          $package = $payment->PatientPackage()->updateOrCreate(
            [
              'patient_id' => $payment->patient_id,
              'payment_id' => $payment->id,

            ],
            [
              'package_id' => $data['package']['id'],
              'variant_id' => $data['package']['variant']['id'],
              'alacarte' => json_encode($data['alacart'])
            ]
          );

          $this->createVouchers($package, $data['package']['variant']['id'], $payment->patient_id, $data['package']['voucher'], $data['alacart']['expiry']);
        }

        switch(request('submit')) {
          case 'save':
            return redirect()->back();
            //return redirect()->route('payment.index', ['patient' => $payment->patient->id]);
            //return redirect()->route('checkin.index');
          break;

          case 'payment-list':
            return redirect()->route('payment.index', ['patient' => $payment->patient->id]);
          break;

          case 'new-appointment':
            return redirect()->route('appointments.create', ['patient' => $payment->patient->id, 'matter' => $payment->matter->id]);
          break;
        }
      } else {
        Session::flash('message', 'Voucher invalid!');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->route('payment.edit', [$payment, '#PaymentTabs3']);
      }

  }

  private function chkRedeemCode($action, $redeemCodes, $payment)
  {
    $returnVal = 'yes';
    //$bla = $payment->discountVouchers->contains('code','FBA10031hmou');
    foreach($redeemCodes as $redeemCode)
    {
      if(!is_null($redeemCode['code'])) {
        if(!$payment->discountVouchers->contains('code',$redeemCode['code'])) {
          if (!PatientVoucher::where('code', $redeemCode['code'])->where('state', 'enable')->exists()) {
            $returnVal = 'no';
          }
        }
      }
    } //endforeach
    return $returnVal;
  }

  private function updatePatientVoucher($redeemCodes, $patient_id, $payment)
  {
    $resetPatientVoucher = PatientVoucher::where('use_in_payment', $payment->id)
                            ->update([
                              'use_in_payment' => null,
                              'claim_by' => null,
                              'state' => 'enable'
                            ]);

    $resetDiscountVoucher = PaymentDiscount::where('payment_id', $payment->id)->where('discountable_type','App\PatientVoucher')->delete();

    foreach($redeemCodes as $redeemCode)
    {
      if(!is_null($redeemCode['code']) && isset($redeemCode['amount'])) {
        $pV = new PatientVoucher;
        $pV = PatientVoucher::where('code', $redeemCode['code'])->first();
        $pV->state = 'claimed';
        $pV->claim_by = $patient_id;
        $pV->use_in_payment = $payment->id;
        $pV->update();

        $payment->discountVouchers()->updateOrCreate(
            [
            'payment_id'   => $payment->id,
            'discountable_type' => 'App\PatientVoucher',
            'code' => $pV->code,
            ],
            [
              'discountable_id' => $pV->id,
              'discount_amount' => $redeemCode['amount'],
            ]
        );

      }
    }
  }

  private function createVouchers($package, $variant_id, $patient_id, $vouchers, $alaExpiry)
  {
    foreach ($vouchers as $key => $voucher) {
      //dd($voucher['voucher_type_id']);
      if($package->id != 18) {
        $setExpired_date = Carbon::now()->addMonths($package->variant->expiry);
      } else {
        $setExpired_date = Carbon::now()->addMonths($alaExpiry);
      }

      $package->patientVouchers()->create([
        'patient_package_id' => $package->id,
        'patient_id' => $patient_id,
        'variant_id' => $variant_id,
        'voucher_type_id' => $voucher['voucher_type_id'],
        'code' => $voucher['code'],
        'expired_date' => $setExpired_date,
        'state' => 'enable',
      ]);
    }
  }

  private function updatePromotion($payment, $promo_id, $promo_amount, $promo_code)
  {
    if($promo_id!=null && $promo_amount!=0) {
      $payment->discountPromotions()->updateOrCreate(
          [
          'payment_id'   => $payment->id,
          'discountable_type' => 'App\ShopPromotion',
          ],
          [
            'discountable_id' => $promo_id,
            'discount_amount' => $promo_amount,
            'code' => $promo_code
          ]
      );

    } else {
      PaymentDiscount::where('payment_id', $payment->id)->where('discountable_type', 'App\ShopPromotion')->delete();
    }
  }

  private function updatePaymentProducts($payment, $paymentProducts)
  {
    //dd($paymentProducts);
    $paymentProducts = collect($paymentProducts);
    $productsAmount = $paymentProducts->sum('total');
      foreach ($paymentProducts as $product) {
        $payment->products()->updateOrCreate(
            [
            'payment_id'   => $payment->id,
            'treat_id' => $payment->treat_id,
            'matter_id' => $payment->matter_id,
            'patient_id' => $payment->patient_id,
            'product_id' => $product['product_id'],
            ],
            [
              'price' => $product['price'],
              'unit' => $product['unit'],
              'total' => $product['total']
            ]
        );
      }
    return $productsAmount;

  }


  private function updatePaymentCollection($payment, $treat)
  {
      if($treat['paid_amount'] > 0) {
        $collection = new PaymentCollection;
        $collection->amount = $treat['paid_amount'];
        $collection->payment_method_id = $treat['method_id'];
        if($treat['paid_date'] != null) {
          $collection->created_at = date('Y-m-d H:i:s', strtotime($treat['paid_date']));
        } else {
          if($payment->treat!=null) {
            $collection->created_at = date('Y-m-d H:i:s', strtotime($payment->treat->treat_date));
          }
        }
        $payment->collections()->save($collection);
      }

      if($payment->collections->sum('amount') >= $treat['total']) {
        $returnState = 'paid';
      } else if($payment->collections->sum('amount') > 0){
        $returnState = 'partial';
      } else {
        $returnState = 'pay';
      }

      return $returnState;
  }

}
