<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoWorkerDetails extends Model
{
    protected $fillable = [
        "name",
        "address",
        "phone_no"
    ];
}
