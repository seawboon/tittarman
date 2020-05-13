<?php

use Illuminate\Database\Seeder;
use App\injury;

class InjuriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $injury = [
          ['name'=>'Tensed Muscle'],
          ['name'=>'Frozen Joint'],
          ['name'=>'Dislocation'],
          ['name'=>'Sprain'],
          ['name'=>'Stress'],
          ['name'=>'Fracture'],
          ['name'=>'Old Injury'],
          ['name'=>'Work-related'],
       ];

      injury::insert($injury);
    }
}
