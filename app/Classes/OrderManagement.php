<?php
namespace App\Classes;

use App\Events\RiderOrderUpdate;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Setting;
use App\Repositories\Interfaces\OrderDestinationRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\OrderScheduleRepositoryInterface;
use App\RiderOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserCoupon;

class OrderManagement
{
    private $orderRepository;
    private $orderScheduleRepository;
    private $orderDestinationRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderScheduleRepositoryInterface $orderScheduleRepository,
        OrderDestinationRepositoryInterface $orderDestinationRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderDestinationRepository = $orderDestinationRepository;
        $this->orderScheduleRepository = $orderScheduleRepository;
    }

    public function create(array $data) {
//   return $data['order_schedule']['order_id'];
// $order = $this->orderRepository->create($data);
        // return $order->id;
        $order = null;
        //  DB::transaction(function () use($order, $data) {
            // return $data;
            $data['user_id'] = Auth::user()->id;
            $order = $this->orderRepository->create($data);
            $data['order_id'] = $order->id;
            return $data['order_id'];
            if ($data['schedule'] === true) {
                $data['order_schedules']['order_id'] = $order->id;
                $this->orderScheduleRepository->create($data['order_schedules']);
            }
//            if ()
            foreach ($data['order_destinations'] as $key => $order_destination) {
                $order_destination['order_id'] = $order->id;
                $this->orderDestinationRepository->create($order_destination);
            }
            UserCoupon::where('user_id', $data['user_id'])->delete();
        //  });
        return $order;

    }

    public function fetch(string $orderId) {
        return $this->orderRepository->fetch($orderId);
    }

    public function user() {
        $userId = Auth::user()->id;
        return $this->orderRepository->user($userId);
    }

    public function all() {
        return $this->orderRepository->all();
    }

    public function update(array $data, string $orderId) {
        if($data['status'] === 'accepted') {
            $settings = json_decode(Setting::all()->toArray()[0]['config'], true);
            if ($settings['assign_orders_automatically'] === "true") {
                $rider = Rider::all()->random(1);
            }
        }
        $orderUpdate = $this->orderRepository->update($orderId, $data);
        $order = Order::where('id', $orderId)->first();
        if($data['status'] === 'accepted') {
            if ($settings['assign_orders_automatically'] === "true") {
                $riderOrder = RiderOrder::create([
                    'order_id' => $order['id'],
                    'rider_id' => $rider[0]['id'],
                ]);
                $orderChannel = 'orders' . '-' . $order['id'];
                $order = Order::with('orderRider.rider.user', 'orderRider.rider.orderRider', 'destinations')->where('id', $order['id'])->first();
                event(new RiderOrderUpdate($order));
            }
        }
    }

}
