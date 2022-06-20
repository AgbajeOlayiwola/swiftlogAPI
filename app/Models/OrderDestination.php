<?php

namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class OrderDestination extends Model
{
    //
    use UuidGenerator;

    protected $fillable = [
        'order_id',
        'address_text',
        'address_lat',
        'address_lng',
        'item_name',
        'recipient_name',
        'recipient_telephone',
        'category',
        'fragile',
    ];

    protected $casts = ['fragile'];

    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }
}
