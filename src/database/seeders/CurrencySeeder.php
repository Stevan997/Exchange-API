<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                'name' => 'JPY',
                'full_name' => 'Japanese Yen',
                'surcharge_percentage' => 7.5
            ],
            [
                'name' => 'GBP',
                'full_name' => 'British Pound Sterling',
                'surcharge_percentage' => 5
            ],
            [
                'name' => 'EUR',
                'full_name' => 'Euro',
                'surcharge_percentage' => 5
            ]
        ];

        foreach ($array as $item) {
            if (!Currency::where('name', $item['name'])->exists()) {
                Currency::create($item);
            }
        }
    }
}
