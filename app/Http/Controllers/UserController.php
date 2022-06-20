<?php

namespace App\Http\Controllers;

use App\Classes\UserManagement;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\UserCoupon;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    private $userManagement;

    public function __construct(UserManagement $userManagement) {
        $this->userManagement = $userManagement;
    }

    public function count(string $userType) {
        return $this->userManagement->count($userType);
    }

    public function users(Request $request) {
        return $this->userManagement->users(10, $request->all());
    }

    public function update(Request $request) {
//        return $request->all();
        $this->validate($request, [
            'email' => 'email',
            'telephone' => 'numeric|unique:users'
        ]);
        return $this->userManagement->update($request->all());
    }

    public function block(Request $request) {
        $user = User::whereId($request->userId)->first();
        return User::whereId($user->id)->update([
            "active" => !$user->active
        ]);
    }

    public function otp() {
        return $this->userManagement->resendOtp();
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'new_password' => 'required|min:8|same:new_password_confirm',
            'new_password_confirm' => 'required|min:8|same:new_password'
        ]);
        return $this->userManagement->updatePassword($request->all());
    }

    public function rider(Request $request) {
        $this->validate($request, [
            'new_password' => 'required|min:8|same:new_password_confirm',
            'new_password_confirm' => 'required|min:8|same:new_password'
        ]);
        return $this->userManagement->updatePassword($request->all());
    }

    public function registerRider(Request $request) {
        $this->validate($request, [
            'email' => 'email|unique:users',
            'telephone' => 'numeric|unique:users'
        ]);
        return $this->userManagement->riderRegister($request->all());
    }

    public function admin() {
        return response()->created(
            "Successfully created coupons",
            User::where("user_type", "admin")->get(),
            "admins"
        );
    }
    
    public function deleteOrders(string $userId) {
        $order = Order::where('user_id', $userId)->delete();
        return response()->updated(
            'Order deleted',
            $order,
            'order'
        );
    }
    
    public function getUserCoupon() {
        $user = Auth::user();
        $userCoupon = UserCoupon::where('user_id', $user->id)->first();
        if ($userCoupon) {
            $coupon = Coupon::where('id', $userCoupon->coupon_id)->first();
            return response()->fetch(
                'User Coupon fetched',
                $coupon,
                'coupon'
            );
        } else{
            throw new ValidationException("Has no coupon");
        }
    }
    
    //mobile otp 
    // public function sendOtp(Request $request){
    //     $otp = rand(1000, 9999);
    //     Log::info(message: "otp = " .$otp);

    //     // $user = users::where('telephone', '=', $request -> mobile)-> update(['otp'=> $otp]);
    //     //send otp to mobile no using sms api
    //     return response()-> json([$user], status: 200);

    // }

    //mobile otp
    public function addCoupon(Request $request) {
        $coupon = Coupon::where('code', $request->code)->first();
        if(!$coupon) {
            throw new ValidationException("Invalide coupon code");
        }
        $order = UserCoupon::create([
            "user_id" => $request->userId,
            "coupon_id" => $coupon->id,
        ]);
        return response()->created(
            "Coupon applied successfully",
            $order,
            "bike"
        );
    }
}
