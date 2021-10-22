<?php

use Illuminate\Database\Seeder;
use App\Payment;
use App\PaymentCollection;

class SyncPaidAmountToPaymentCollection extends Seeder
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
          if($payment->paid_amount > 0) {
            $collection = new PaymentCollection;
            $collection->collectable_id = $payment->id;
            $collection->collectable_type = 'App\Payment';
            $collection->amount = $payment->paid_amount;
            $collection->payment_method_id = $payment->method_id;
            $collection->save();
            $payment->paid_amount = 0;
            $payment->save();
          }
         }
      });
    }
}
