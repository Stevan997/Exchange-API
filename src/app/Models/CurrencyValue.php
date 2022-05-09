<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyValue extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'currency_values';

    /**
     * @var string[]
     */
    protected $fillable = [
        'currency_id',
        'value',
    ];
}
