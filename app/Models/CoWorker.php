<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'co_worker_name',
        'date_and_time',
        'normal_saree',
        'border_saree',
        'big_border_saree',
    ];
}


