<?php

namespace App;

use App\Models\Order;
use App\Models\Rider;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class RiderOrder extends Model
{
    //
    use UuidGenerator;

    public $guarded = [];

    public function order() {
        return $this->belongsTo(Order::class)->orderByDesc('created_at');
    }

    public function rider() {
        return $this->belongsTo(Rider::class);
    }
}
