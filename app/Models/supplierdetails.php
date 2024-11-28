<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class supplierdetails extends Model
{
    protected $fillable = [
        "name",
        "address",
        "phone_no"
    ];
}
