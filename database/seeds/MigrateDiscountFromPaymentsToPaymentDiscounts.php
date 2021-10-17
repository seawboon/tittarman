<?php

use Illuminate\Database\Seeder;
use App\Payment;
use App\PaymentDiscount;
use App\PatientVoucher;

class MigrateDiscountFromPaymentsToPaymentDiscounts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Payment::query()->orderBy('id')->chunk(100, function ($payments) {
         foreach ($payments as $payment) {
          if($payment->discount_code != '') {
            $voucher = PatientVoucher::where('code', $payment->discount_code)->first();
            $discount = new PaymentDiscount;
            $discount->payment_id = $payment->id;
            $discount->discountable_type = 'App\PatientVoucher';
            $discount->discountable_id = $voucher->id;
            $discount->code = $payment->discount_code;
            $discount->discount_amount = $payment->discount;
            $discount->save();
          }
         }
      });
    }
}
