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
       
        
        $max = 50;
        $faker = (new Faker\Factory())::create('nl_NL');
        $faker->addProvider(new Fakecar($faker)); 
        $valsCars = DB::table('auto')->offset(0)->limit(10)->get();
        $trueCars = DB::table('auto')->offset(10)->limit($max)->get();
        $cars = $this->copyCars(DB::table('auto')->get());
        $valsCarsArr = $this->valsCars($faker, $valsCars);     
        $trueCarsArr = $this->copyScannedCars($trueCars);
        $gescandeAutos = array_merge($valsCarsArr, $trueCarsArr);
        $this->insertGescandeAutos($gescandeAutos);   
        $this->insertAutos($cars);   
    }

           
    public function valsCars($faker, $autos) {
        $valsCars = [];
        foreach ($autos as $auto) {
            $car = $faker->vehicleArray;
            $valsCar = [
                        //'id' => $auto->id,
                        'kenteken' => $auto->kenteken,
                        'voertuigsoort' => $faker->vehicleType,
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
        $autoArr = $autos->toArray();
        shuffle($autoArr);
        foreach ($autoArr as $auto) {
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
    public function copyCars($autos) {
        $trueCars = [];
        $autoArr = $autos->toArray();
        shuffle($autoArr);
        foreach ($autoArr as $auto) {
            $trueCar = [
                    'id' => $auto->id,
                    'kenteken' => $auto->kenteken,
                    'voertuigsoort' => $auto->voertuigsoort,
                    'merk' => $auto->merk,
                    'model' => $auto->model,
                    'brandstof' => $auto->brandstof,
                    'kleur' => $auto->kleur,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]; 
            $trueCars[] = $trueCar;    
        }  
        return $trueCars;                 
    }
    public function insertGescandeAutos($autos) {
        DB::table('gescande_auto')->insert($autos);
    }

    public function insertAutos($autos) {
        DB::table('auto')->delete();
        DB::table('auto')->insert($autos);
    }

    public function getRandomCars($amount) {
        //Get random $amount cars
        $cars = DB::table('auto')->select('id')->get()->toArray;
        shuffle($cars);
        $randCars = array_slice($cars, $amount);
        return $randCars;
    }
}