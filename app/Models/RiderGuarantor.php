<?php

namespace App\Models;


use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class RiderGuarantor extends Model
{
    use UuidGenerator;

    protected $guarded = [];

    public function rider() {
        return $this->belongsTo(Rider::class);
    }
}
