<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'co_worker_id',
        'date_and_time',
        'ns',
        'bs',
        'bbs',
        'rns',
        'rbs',
        'rbbs',
    ];
}


