<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;
use Faker\Provider\Fakecar;
use App\Lib\AutoFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = (new Faker\Factory())::create('nl_NL');
        $faker->addProvider(new Fakecar($faker));
        //$car = $faker->vehicleArray;
        $autoFaker = new AutoFaker;
        $car = $autoFaker->getCar();
        $fuels = ['hybride', 'benzine', 'diesel'];
        $fuel = $fuels[array_rand($fuels, 1)];

        return [
            'kenteken' => $this->makeLicense(),
            'voertuigsoort' => "personenauto",
            'merk' => $car['brand'],
            'model' => $car['model'],
            'brandstof' => $fuel,
            'kleur' => $faker->colorName()
        ];
    }

    
    public function makeLicense() {
        $letters = ['A','B','C','D','E','F','G','H','J','K','L','M','N','P','R','S','T','U','V','W','X','Y','Z'];
        $letter = $letters[rand(0, count($letters) - 1)];
        $letterduo = $letters[rand(0, count($letters) - 1)].$letters[rand(0, count($letters) - 1)];
        $lettertrio = $letters[rand(0, count($letters) - 1)].$letters[rand(0, count($letters) - 1)].$letters[rand(0, count($letters) - 1)];
        $cijfer = random_int(0,9);
        $cijferduo = random_int(0,9).random_int(0,9);
        $cijfertrio = random_int(0,9).random_int(0,9).random_int(0,9);
        
        $kentekens = [
            "1951" => $letterduo."-".$cijferduo."-".$cijferduo,
            "1965" => $letterduo."-".$letterduo."-".$cijferduo,
            "2004" => $cijferduo."-".$lettertrio."-".$cijfer,
            "2013" =>$cijfer."-".$lettertrio."-".$cijferduo,
            "2015" => $letterduo."-".$cijfertrio."-".$letter,
            "2016" => $cijfer."-".$letterduo."-".$cijfertrio,
            "2021" => $letter."-".$cijfertrio."-".$letterduo,
        ];

        return $kentekens[array_rand($kentekens)];
    }

    
}
