<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CurrencyService
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function all(Request $request): Collection
    {
        return Currency::with('values')->get();
    }
}
