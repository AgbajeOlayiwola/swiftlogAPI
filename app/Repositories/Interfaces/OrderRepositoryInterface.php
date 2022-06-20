<?php
namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface {
    public function create(array $data): Order;

    public function fetch(string $orderId);

    public function user(string $userId): Collection;

    public function all(): Collection;

    public function update($order, array $data);
}
