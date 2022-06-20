<?php

namespace App\Models;


use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class UserTicket extends Model
{
    use UuidGenerator;

    protected $guarded = [];

    public function ticket() {
        return $this->belongsTo(TicketCategory::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
