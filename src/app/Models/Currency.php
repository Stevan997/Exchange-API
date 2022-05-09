<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * @var string
     */
    protected $table = 'currencies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'full_name',
        'surcharge_percentage',
        'active'
    ];
}
