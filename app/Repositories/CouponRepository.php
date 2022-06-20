<?php


namespace App\Repositories;


use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Traits\ExceptionsHandlers;
use App\Traits\updateModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    use ExceptionsHandlers, updateModel;

    protected $couponFields = [
        'code' => 'code',
        'name' => 'name',
        'expiry_date' => 'expiry_date',
    ];

    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Coupon
    {
        $coupon = $this->model->create($data);
        $this->checkIfResourceFound($coupon, "Error creating coupon");
        return $coupon;
    }

    public function fetch(string $couponId): Coupon
    {
        $coupon = $this->model->find($couponId);
        $this->checkIfResourceFound($coupon, "Coupon not found");
        return $coupon;
    }

    public function code(string $code): Coupon
    {
        $coupon = $this->model->where('code', $code)->first();
        $this->checkIfResourceFound($coupon, "Coupon not found");
        return $coupon;
    }

    public function all(): Collection
    {
        $coupon = $this->model::all();
        foreach ($coupon as $key => $user) {
            $coupon[$key]['created_at_human'] = Carbon::parse($user->expiry_date)->format("d M Y");
        }
        return $coupon;
    }

    public function edit(string $couponId, array $data): Coupon
    {
        $coupon = $this->fetch($couponId);
        $this->updateModelAttributes($coupon, $data, $this->couponFields);
        $coupon->save();
        return $coupon;
    }
}
