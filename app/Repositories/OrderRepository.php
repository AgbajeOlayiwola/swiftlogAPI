<?php


namespace App\Repositories;


use App\Events\RiderOrderUpdate;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Traits\ExceptionsHandlers;
use App\Traits\updateModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    use ExceptionsHandlers, updateModel;

    protected $orderFields = [
        'status' => 'status'
    ];

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    public function fetch(string $orderId)
    {
        $orders = $this->model->with('destinations', 'schedule', 'user', 'orderRider.rider')
        ->orderBy('created_at', 'DESC')
            ->get();
        foreach ($orders as $order) {
            $id = explode('-', $order->id);
            $result = substr($id[0], 0, 5);
            if ($result === $orderId) {
                return $order;
            }
        }
    }

    public function user(string $userId): Collection
    {
        $orders = $this->model->with('destinations', 'schedule', 'user')
            ->where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
        $this->checkIfResourceFound($orders, "User Orders not found.");
        foreach ($orders as $key => $order) {
            $orders[$key]['created_at_human'] = Carbon::parse($order->created_at)->format("jS F Y at g:i A");
        }
        return $orders;
    }

    public function all(): Collection
    {
        $orders = $this->model->with('destinations', 'schedule', 'user', 'orderRider.rider.user')
            ->orderBy('created_at', 'DESC')
            ->get();
        $this->checkIfResourceFound($orders, "User Orders not found.");
        foreach ($orders as $key => $order) {
            $orders[$key]['created_at_human'] = Carbon::parse($order->created_at)->format("jS F Y");
            $orders[$key]['created_at_human_dual'] = Carbon::parse($order->created_at)->format("jS F Y g:i A");
        }
        return $orders;
    }

    public function update($order, array $data)
    {
        Order::where('id', $order)->update(['status' => $data['status']]);
        $order2 = Order::with('orderRider.rider.user', 'orderRider.rider.orderRider', 'destinations')->where('id', $order)->first();
        event(new RiderOrderUpdate($order2));
        return $order;
    }
}
