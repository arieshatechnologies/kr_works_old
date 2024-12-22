<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoWorkerPayment extends Model
{
    protected $fillable = [
        'co_worker_id',
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
