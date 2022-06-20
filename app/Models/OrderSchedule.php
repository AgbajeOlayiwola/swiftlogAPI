<?php

namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class OrderSchedule extends Model
{
    //
    use UuidGenerator;

    protected $fillable = [
        'order_id',
        'pickup'
    ];

    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }
}
