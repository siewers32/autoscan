<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker;
use Faker\Provider\Fakecar;

class GescandeAutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = (new Faker\Factory())::create('nl_NL');
        $faker->addProvider(new Fakecar($faker));
        $cars = $this->getRandomCars(150);
        $trueCars = $this->copyScannedCars($cars); 
        $fakeCars = $this->valsCars($faker, $this->getFakeCars($cars, 6));
        //$autos = $this->valsCars($faker, $this->getRandomCars(6));
        DB::table('gescande_auto')->insert($trueCars);
        foreach($fakeCars as $fc) {
            DB::table('gescande_auto')->where('kenteken', $fc['kenteken'])->update($fc); 
        }  
    }

           
    public function valsCars($faker, $autos) {
        $valsCars = [];
        foreach ($autos as $auto) {
            $car = $faker->vehicleArray;
            $valsCar = [
                        //'id' => $auto->id,
                        'kenteken' => $auto->kenteken,
                        'voertuigsoort' => "personenauto",
                        'merk' => $car['brand'],
                        'model' => $car['model'],
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
            ];
            $valsCars[] = $valsCar;
        }
        return $valsCars;
    }                   
    
    
    public function copyScannedCars($autos) {
        $trueCars = [];
        //$autoArr = $autos->toArray();
        //shuffle($autoArr);
        foreach ($autos as $auto) {
            $trueCar = [
                   // 'id' => $auto->id,
                    'kenteken' => $auto->kenteken,
                    'voertuigsoort' => $auto->voertuigsoort,
                    'merk' => $auto->merk,
                    'model' => $auto->model,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]; 
            $trueCars[] = $trueCar;    
        }  
        return $trueCars;                 
    }

    public function getRandomCars($amount) {
        //Get random $amount cars
        $cars = DB::table('auto')->get()->toArray();
        shuffle($cars);
        $randomCars = array_slice($cars,0,$amount);
        return $randomCars;
    }

    public function getFakeCars($cars, $amount) {
        shuffle($cars);
        $fakeCars = array_slice($cars,0,$amount);
        return $fakeCars;
    }

}