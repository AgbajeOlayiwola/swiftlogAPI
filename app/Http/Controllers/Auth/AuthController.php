<?php

namespace App\Http\Controllers\Auth;

use App\Classes\AuthClass;
use App\Models\Otp;
use App\Classes\UserManagement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomValidationFailed;

class AuthController extends Controller
{
    //
    /**
     * @var AuthClass
     */
    private $authClass;

    private $userManagement;

    public function __construct(UserManagement $userManagement, AuthClass $authClass) {
        $this->authClass = $authClass;
        $this->userManagement = $userManagement;
    }

    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        return $this->authClass->loginUser($request->only(['email','password']));
    }
    public function allotp(){
        $otpList = Otp::all();
        return response()->json(['otp'=> $otpList], 200);

    }

    public function register(Request $request){
        // dd($request);
        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'password' => 'required', //removed confirmed 
            'name' => 'required|string',
            'telephone' => 'required|numeric|unique:users',
            'user_type' => 'required',
            'business_category' => 'required',
            'address_text' => 'required'
        ]);
        return $this->userManagement->register($request->all());
    }

    public function registerMember(Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'name' => 'required|string',
            'telephone' => 'required|numeric',
            'user_type' => 'required',
        ]);
        return $this->userManagement->registerMemeber($request->all());
    }

    public function registerRider(Request $request){
        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|string',
            'telephone' => 'required|numeric|unique:users',
            'guarantors' => 'required',
            'user_type' => 'required',
        ]);
        return $this->userManagement->registerMemeber($request->all());
    }

    public function userVerification(Request $request){
        $this->validate($request,[
            'otp' => 'required'
        ]);
        $user =  $request->user();

        return $this->authClass->verifyUserEmail($user,$request->otp);
    }

    public function resendVerification(Request $request){
        $user = $request->user();
        return $this->authClass->resendVerificationEmail($user);
    }

    public function resetPasswordMail(Request $request){
        if (count(User::where('email', $request->email)->get())  > 0) {
            return $this->authClass->sendResetPasswordMail($request->email);   
        }else {
            throw new CustomValidationFailed("Old password is wrong.");
        }
    }

    public function checkToken() {
        return response()->fetch(
            "Checking authentication",
            Auth::check(),
            'auth'
        );
    }

    public function passwordReset(Request $request){
        $this->validate($request,[
            'password'=> 'required|confirmed'
        ]);
        $user =  $request->user();
        return $this->authClass->resetPassword($user,$request->only(['password']));
    }
}
