<?php
namespace App\Classes;

use App\Repositories\Interfaces\CouponRepositoryInterface;

class CouponManagement
{

    protected $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function create(array $data) {
        return response()->created(
            "Successfully created coupons",
            $this->couponRepository->create($data),
            "coupons"
        );
    }

    public function edit(string $couponId, array $data) {
        return response()->updated(
            "Successfully updated coupons",
            $this->couponRepository->edit($couponId, $data),
            "coupons"
        );
    }

    public function all() {
        return response()->fetch(
            "Successfully updated coupons",
            $this->couponRepository->all(),
            "coupons"
        );
    }
}
