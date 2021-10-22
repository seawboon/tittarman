<?php

use Illuminate\Database\Seeder;
use App\Payment;
use App\PaymentCollection;

class SyncPaymentDateWithPaymentCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       PaymentCollection::query()->orderBy('id')->chunk(100, function ($collections) {
         foreach ($collections as $collection) {
           $payment = Payment::find($collection->collectable_id);
           $collection->created_at = $payment->created_at;
           $collection->updated_at = $payment->created_at;
           $collection->save();
         }
      });
    }
}
