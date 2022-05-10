<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /**
     * @var string
     */
    protected string $table = 'orders';

    /**
     * @var string[]
     */
    protected array $fillable = [
        'currency_value_id',
        'surcharge_percentage',
        'surcharge_amount',
        'purchased_amount',
        'paid_amount',
        'discount_percentage',
        'discount_amount',
    ];

    /**
     * @return BelongsTo
     */
    public function currencyValue(): BelongsTo
    {
        return $this->belongsTo(CurrencyValue::class,'currency_value_id', 'id');
    }
}
