<?php

namespace App\Repositories\Interfaces;

use App\Models\Rider;
use Illuminate\Database\Eloquent\Collection;

interface RiderRepositoryInterface {
    public function create(array $data): Rider;

    public function all(): Collection;
}
