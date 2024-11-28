<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class supplier_payment extends Model
{
    protected $fillable = [
        'supplier_id',
        'ns',
        'bs',
        'bbs',
        'ans',
        'abs',
        'abbs',
        'total_amount',
        'given_amount',
        'status',
        'start_date',
        'end_date',
    ];
}
