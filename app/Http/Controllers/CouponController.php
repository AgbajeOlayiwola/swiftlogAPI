<?php

namespace App\Http\Controllers;

use App\Classes\CouponManagement;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    protected $couponManagement;
    public function __construct(CouponManagement $couponManagement)
    {
        $this->couponManagement = $couponManagement;
    }

    public function create(Request $request) {
        return $this->couponManagement->create($request->all());
    }

    public function edit(Request $request, string $couponId) {
        return $this->couponManagement->edit($couponId, $request->all());
    }

    public function all() {
        return $this->couponManagement->all();
    }
}
