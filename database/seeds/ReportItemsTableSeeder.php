<?php

use App\Items;
use App\Report;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $items = Items::where('status', true)->get()->pluck('id')->toArray();
        $reports = Report::where('status', true)->get()->pluck('id')->toArray();
        foreach ($reports as $report) {
            for ($i = 0; $i < 30; $i++) {
                DB::table('report_items')->insert([
                    'reportID' => $report,
                    'itemID' => $faker->randomElement($items),
                    'portions' => $faker->numberBetween($nbMaxDecimals = 3, $min = 50, $max = 200),
                    'quantity' => $faker->numberBetween($nbMaxDecimals = 3, $min = 20, $max = 100),
                    'price' => $faker->numberBetween($nbMaxDecimals = 3, $min = 1500, $max = 4000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
