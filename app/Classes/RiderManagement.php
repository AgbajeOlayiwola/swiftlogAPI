<?php

namespace App\Classes;

use App\Events\RiderOrderUpdate;
use App\Models\Order;
use App\Repositories\Interfaces\RiderGuarantorRepositoryInterface;
use App\Repositories\Interfaces\RiderRepositoryInterface;
use App\RiderOrder;
use App\RiderScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

class RiderManagement
{
    private $riderRepository;

    private $riderGuarantorRepository;

    public function __construct(
        RiderRepositoryInterface $riderRepository,
        RiderGuarantorRepositoryInterface $riderGuarantorRepository
    ) {
        $this->riderRepository = $riderRepository;
        $this->riderGuarantorRepository = $riderGuarantorRepository;
    }

    public function all() {
        $riders = $this->riderRepository->all()->toArray();
        foreach ($riders as $key => $rider) {
            $riders[$key]['total_score'] = 0;
            if (count($riders[$key]['score']) !== 0 ) {
                foreach ($riders[$key]['score'] as $score) {
                    $riders[$key]['total_score'] += $score['score'];
                }
                $riders[$key]['total_score'] = $riders[$key]['total_score']/count($riders[$key]['score']);
            } else {
                $riders[$key]['total_score'] = 0;
            }
            foreach ($riders[$key]['order_rider'] as $keys => $order) {
                $riders[$key]['order_rider'][$keys]['order']['created_at_human'] = Carbon::parse($order['order']['created_at'])->format("jS F Y");
                $riders[$key]['order_rider'][$keys]['order']['created_at_human_dual'] = Carbon::parse($order['order']['created_at'])->format("jS F Y g:i A");
            }
            $riders[$key]['created_at_human'] = Carbon::parse($riders[$key]['created_at'])->format("jS F Y");
        }
        return response()->fetch(
            'Riders fetched',
            $riders,
            'riders'
        );
    }

    public function orderToRider(array $data) {
        $riderOrder = RiderOrder::create([
            'order_id' => $data['order_id'],
            'rider_id' => $data['rider_id'],
        ]);
        $orderChannel = 'orders'. '-' . $data['order_id'];
        $order = Order::with('orderRider.rider.user', 'orderRider.rider.orderRider', 'destinations')->where('id', $data['order_id'])->first();
        event(new RiderOrderUpdate($order));
//        return Broadcast::channel($orderChannel,  function () use ($order) {
//            return $order;
//        });
        return $riderOrder;
    }

    public function scoreRider(array $data) {
        return RiderScore::create($data);
    }
}
