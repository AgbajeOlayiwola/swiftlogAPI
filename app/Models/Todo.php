<?php

namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use UuidGenerator;

    protected $guarded = [];
}
