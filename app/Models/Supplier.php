<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'date',
        'ns',
        'rns',
        'bs',
        'rbs',
        'bbs',
        'rbbs',
    ];
}
