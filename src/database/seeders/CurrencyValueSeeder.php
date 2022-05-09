<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyValue;
use Illuminate\Database\Seeder;

class CurrencyValueSeeder extends Seeder
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
                'currency_id' => Currency::where('name', 'JPY')->first()->id,
                'value' => 107.17,
            ],
            [
                'currency_id' => Currency::where('name', 'GBP')->first()->id,
                'value' => 0.711178,
            ],
            [
                'currency_id' => Currency::where('name', 'EUR')->first()->id,
                'value' => 0.884872,
            ]
        ];

        foreach ($array as $item) {
            if (!CurrencyValue::where('currency_id', $item['currency_id'])->exists()) {
                CurrencyValue::create($item);
            }
        }
    }
}
