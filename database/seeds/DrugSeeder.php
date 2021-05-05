<?php

use Illuminate\Database\Seeder;
use App\Drug;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $drugs = [
          ['name'=>'HP', 'color'=>'#C0392B'],
          ['name'=>'TTP', 'color'=>'#F4D03F'],
          ['name'=>'CP', 'color'=>'#5499C7'],
       ];

       Drug::insert($drugs);

    }
}
