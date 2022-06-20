<?php
namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model {
    use UuidGenerator;

    protected $table = "email_otp";
   
    protected $fillable = [
        "otp",
        "user_id"
    ];
}
