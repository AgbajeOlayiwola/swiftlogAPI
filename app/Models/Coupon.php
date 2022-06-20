<?php

namespace App\Models;


use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use UuidGenerator;

    protected $guarded = [];

    protected $casts = [
        'expiry_date'  => 'date:Y-m-d',
    ];
}
