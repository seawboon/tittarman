<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class AutoGenerateUuidForPatients extends Seeder
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
        $user->uuid = Uuid::uuid4()->toString();
        $user->save();
       }
      });
    }
}
