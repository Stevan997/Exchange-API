<?php

namespace App\Models;

class Order
{
    /**
     * @var string
     */
    protected $table = 'currency_values';

    /**
     * @var string[]
     */
    protected $fillable = [
        'currency_value_id',
        'surcharge_percentage',
        'surcharge_amount',
        'purchased_amount',
        'paid_amount',
        'discount_percentage',
        'discount_amount',
    ];
}
