<?php

use Illuminate\Database\Seeder;
use App\Branches;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $venues = [
          ['name'=>'Mid Valley Exhibition Centre', 'short'=>'MVEC'],
          ['name'=>'Plaza Arkadia', 'short'=>'ARK'],
       ];

      Branches::insert($venues);
    }
}
