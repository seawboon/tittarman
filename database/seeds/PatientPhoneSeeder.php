<?php

use Illuminate\Database\Seeder;

class PatientPhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \App\Patient::query()->orderBy('id')->chunk(100, function ($users) {
       foreach ($users as $user) {
        $user->phone = $user->provider.$user->contact;
        $user->save();
       }
      });
    }
}
