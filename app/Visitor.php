<?php

namespace App;

use App\Models\User;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
    use UuidGenerator;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
