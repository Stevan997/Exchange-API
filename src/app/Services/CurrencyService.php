<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CurrencyService extends ApiService
{
    /**
     * @return Builder[]|Collection
     */
    public function all(): Collection
    {
        return Currency::with(['values' => function ($query) {
            $query->latest();
        }])->get();
    }

    public function sync()
    {
        foreach ($this->all() as $currency) {
            try {
                $result = $this->getLiveCurrencyData($currency->name);
                if($result['success']) {
                    $this->update($result['result'], $currency);
                }
            } catch (\Exception $exception) {
                Log::critical($exception->getMessage());
            }
        }
    }

    /**
     * @param float $result
     * @param Currency $currency
     */
    private function update(float $result, Currency $currency)
    {
        if($currency->values[0]->value != $result) {
            $currency->values()->delete();
            $currency->values()->create([
                'value' => $result
            ]);
        }
    }
}
