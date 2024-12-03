<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoWorkerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'co_worker_id',
        'total_sarees',
        'returned_sarees',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'status',
    ];
}
