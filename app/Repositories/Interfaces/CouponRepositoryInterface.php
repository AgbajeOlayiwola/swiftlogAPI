<?php

namespace App\Repositories\Interfaces;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

interface CouponRepositoryInterface {
    public function create(array $data): Coupon;

    public function fetch(string $couponId): Coupon;

    public function code(string $code): Coupon;

    public function all(): Collection;

    public function edit(string $couponId, array $data): Coupon;
}
