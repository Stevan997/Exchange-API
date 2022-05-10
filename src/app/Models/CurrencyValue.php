<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyValue extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected string $table = 'currency_values';

    /**
     * @var string[]
     */
    protected array $fillable = [
        'currency_id',
        'value',
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
