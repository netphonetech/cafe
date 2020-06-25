<?php

use App\Report;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 24; $i++) {
            Report::insert([
                'date' => $faker->dateTimeThisMonth(),
                'actual_amount' => $faker->numberBetween($nbMaxDecimals = 3, $min = 100000, $max = 500000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
