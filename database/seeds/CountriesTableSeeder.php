<?php

use Illuminate\Database\Seeder;

use App\Country;
use App\State;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/data/countries.json";
        $json = json_decode(file_get_contents($path), true);


        foreach($json as $data) {

            $countryName = $data['country'];
            $stateNamesData = $data['states'];

            $country = new Country;
            $country->name = $countryName;
            $country->save();

            foreach($stateNamesData as $stateName) {
                $state = new State;
                $state->name = $stateName;
                $country->states()->save($state);
            }

        }
    }
}
