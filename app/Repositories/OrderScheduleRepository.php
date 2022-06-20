<?php
namespace App\Repositories;


use App\Models\Order;
use App\Models\OrderSchedule;
use App\Repositories\Interfaces\OrderScheduleRepositoryInterface;
use App\Traits\ExceptionsHandlers;
use Illuminate\Database\Eloquent\Model;

class OrderScheduleRepository extends BaseRepository implements OrderScheduleRepositoryInterface {
    use ExceptionsHandlers;

    public function __construct(OrderSchedule $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): OrderSchedule
    {
        return $this->model->create($data);
    }

    public function fetch(string $orderId): Order
    {
        $orderSchedule = $this->model->where('order_id', $orderId)->get();
        $this->checkIfResourceFound($orderSchedule, 'Order schedule not found');
        return $orderSchedule;
    }
}
