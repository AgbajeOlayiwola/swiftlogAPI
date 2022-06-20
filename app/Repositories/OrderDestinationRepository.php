<?php


namespace App\Repositories;


use App\Models\OrderDestination;
use App\Repositories\Interfaces\OrderDestinationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderDestinationRepository extends BaseRepository implements OrderDestinationRepositoryInterface
{
    public function __construct(OrderDestination $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): OrderDestination
    {
        return $this->model->create([
            'order_id' => $data['order_id'],
            'address_text' => $data['destination']['formatted_address'],
            'address_lat' => $data['address_lat'],
            'address_lng' => 0.323,
            'item_name' => $data['category'],
            'category' => $data['category'],
            'fragile' => $data['fragile'],
            'recipient_name' => $data['recipient_name'],
            'recipient_telephone' => $data['recipient_telephone'],
        ]);
    }

    public function fetch(string $orderId): Collection
    {
        return $this->model->where('order_id', $orderId)->get();
    }
}
