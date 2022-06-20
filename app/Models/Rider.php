<?php

namespace App\Models;


use App\RiderOrder;
use App\RiderScore;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use UuidGenerator;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function guarantors() {
        return $this->hasMany(RiderGuarantor::class);
    }

    public function bikes() {
        return $this->hasMany(BikeRider::class);
    }

    public function orderRider() {
        return $this->hasMany(RiderOrder::class);
    }

    public function score() {
        return $this->hasMany(RiderScore::class);
    }
}
