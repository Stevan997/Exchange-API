<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    /**
     * @var string
     */
    protected string $table = 'currencies';

    /**
     * @var string[]
     */
    protected array $fillable = [
        'name',
        'full_name',
        'surcharge_percentage',
        'active'
    ];

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(CurrencyValue::class, 'currency_id', 'id');
    }
}
