<?php

namespace App\Models;


use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use UuidGenerator;

    protected $guarded = [];

    public function coupons() {
        return $this->hasMany(Coupon::class);
    }
}
