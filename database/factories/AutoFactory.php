<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;
use Faker\Provider\Fakecar;

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
        $car = $faker->vehicleArray;
        return [
            'kenteken' => $faker->unique->vehicleRegistration('[A-Z]{2}-[A-Z]{2}-[0-9]{2}'),
            'voertuigsoort' => $faker->vehicleType,
            'merk' => $car['brand'],
            'model' => $car['model'],
            'brandstof' => $faker->vehicleFuelType,
            'kleur' => $faker->colorName()
        ];
    }
}
