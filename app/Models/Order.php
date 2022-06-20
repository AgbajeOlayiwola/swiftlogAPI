<?php

namespace App\Models;

use App\RiderOrder;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use UuidGenerator;

    protected $fillable = [
        'destination',
        'address_text',
        'address_lat',
        'address_lng',
        'price',
        'user_id',
        'estimated_distance',
        'status',
        'schedule',
        'payment_method',
        'payment_status'
    ];

    protected $casts = [ 'schedule' ];

    public function destinations() {
        return $this->hasMany(OrderDestination::class);
    }

    public function finalAddress() {
        return $this->hasOne(OrderDestination::class)->latest();
    }

    public function schedule() {
        return $this->hasOne(OrderSchedule::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderRider() {
        return $this->hasOne(RiderOrder::class);
    }
}
