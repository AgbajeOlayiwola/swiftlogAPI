<?php
namespace App\Repositories\Interfaces;

use App\Models\OrderDestination;
use Illuminate\Database\Eloquent\Collection;

interface OrderDestinationRepositoryInterface {
    public function create(array $data): OrderDestination;

    public function fetch(string $orderId): Collection;
}
