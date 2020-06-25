<?php

use App\Items;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 200; $i++) {
            Items::insert([
                'item' => $faker->realText($maxNbChars = 20, $indexSize = 2),
                'unit_measure' => $faker->realText($maxNbChars = 10, $indexSize = 2),
                'unit_amount' => $faker->numberBetween($nbMaxDecimals = 3, $min = 500, $max = 1000),
                'ratio_produced' => $faker->numberBetween($min = 1, $max = 9),
                'price' => $faker->randomFloat($nbMaxDecimals = 3, $min = 1500, $max = 6000),
                'description' => $faker->realText($maxNbChars = 2000, $indexSize = 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
