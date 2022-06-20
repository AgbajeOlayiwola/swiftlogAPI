<?php
namespace App\Repositories\Interfaces;

use App\Models\Order;
use App\Models\OrderSchedule;

interface OrderScheduleRepositoryInterface {
    public function create(array $data): OrderSchedule;

    public function fetch(string $orderId): Order;
}
