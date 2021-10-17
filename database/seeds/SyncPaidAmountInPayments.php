<?php

use Illuminate\Database\Seeder;

class SyncPaidAmountInPayments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \App\Payment::query()->orderBy('id')->chunk(100, function ($payments) {
       foreach ($payments as $payment) {
        if($payment->state == 'paid') {
          $payment->paid_amount = $payment->total;
          $payment->save();
        }
       }
      });
    }
}
