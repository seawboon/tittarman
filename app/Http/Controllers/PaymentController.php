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
use App\TreatProduct;
use App\Images;
use App\Checkin;
use App\Payment;
use Image;
use File;

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

      //$treat->load('products');

      return view('payment.edit', compact('payment','products', 'days'));
  }

  public function update(Payment $payment, Request $request)
  {
      $data = request()->validate([
        'product.*' => '',
        'treat.discount' => 'required',
        'treat.discount_code' => '',
        'treat.total' => 'required',
      ]);

      $data['treat']['product_amount'] = $data['treat']['total'] + $data['treat']['discount'] - $request->treat['fee'];
      $data['treat']['state'] = 'paid';
      //TreatProduct::where('treat_id', $treat->id)->delete();

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



      //return view('matter.edit', compact('patient', 'matter', 'injuries', 'matter_injuries'));
  }

}
