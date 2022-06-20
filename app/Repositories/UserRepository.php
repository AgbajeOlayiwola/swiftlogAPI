<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ExceptionsHandlers;
use App\Traits\updateModel;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Param;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    use ExceptionsHandlers, updateModel;

    protected $userFields = [
        'name' => 'name',
        'email' => 'email',
        'telephone' => 'telephone',
        'business_category' => 'business_category',
        'active' => 'active'
    ];

    public function __construct(User $model) {
        parent::__construct($model);
    }

    public function create(array $data): User
    {
        return $this->model->create([
            'email' => $data['email'],
            'password' => $data['password'],
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'business_category' => $data['business_category'],
            'user_type' => $data['user_type'],
            'address_text' => $data['address_text'],
            'address_latitude' => $data['address_latitude'],
            'address_longitude' => $data['address_longitude']
        ]);
    }

    public function createMember(array $data): User
    {
        return $this->model->create($data);
    }

    public function findById(string $id): ?User {
        return $this->model->whereId($id)->first();
    }

    public function userCount(string $userType): int {
        return count($this->model->with('orders')->where('user_type', $userType)->get()->toArray());
    }

    public function fetch($limit, array $data)
    {
        $users = $this->model->with('orders', 'orders.finalAddress', 'usercoupon')->where('user_type', $data['type'])
            ->get();
        foreach ($users as $key => $user) {
            $users[$key]['order_count'] = count($user->orders);
            if($user->usercoupon){
                $users[$key]['coupon'] = Coupon::where('id', $user->usercoupon['coupon_id'])->first();
            }
            $users[$key]['coupon_value'] = count($user->orders);
            $users[$key]['created_at_human'] = Carbon::parse($user->created_at)->format("jS F Y");
            $to = $user->created_at;
            $from = \Carbon\Carbon::now();
            $users[$key]['duration'] = $to->diffInMonths($from);
            if (count($user->orders) > 0) {
                $users[$key]['last_order_status'] = $user->orders[count($user->orders) -1]['status'];
                foreach ($user->orders as $orderKey => $order) {
                    $users[$key]->orders[$orderKey]['created_at_human'] = Carbon::parse($order->created_at)->format("jS F Y");
                }
            } else {
                $users[$key]['last_order_status'] = 'Not Available';
            }
        }
        return $users;
    }

    public function update($user, array $data) {
        $this->updateModelAttributes($user, $data, $this->userFields);
        $user->save();
        return $user;
    }

    public function updatePassword(string $password, $user) {
        return $this->model->where('id', $user->id)->update([
            "password" => $password
        ]);
    }
}
