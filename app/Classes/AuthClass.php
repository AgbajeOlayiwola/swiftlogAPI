<?php


namespace App\Classes;


use App\Events\AccountRegistered;
use App\Events\PasswordReset;
use App\Exceptions\CustomValidationFailed;
use App\Exceptions\RecordNotFoundException;
use App\Http\Resources\UserResource;
use App\Models\Otp;
use App\Models\User;
use App\Models\UserActivity;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ActivityManager;
use App\Traits\ExceptionsHandlers;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid as Uuid;
use Tymon\JWTAuth\JWT;

class AuthClass
{

    use ExceptionsHandlers;
    /**
     * @var User
     */
    private $user;

    private  $auth;

    private $activityLog;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->user = new User();
        $this->auth = Auth::guard('api');
        $this->userRepository = $userRepository;
    }

    public function loginUser($data){
        $user = null;
        DB::transaction(function () use (&$user,$data){
            $token = $this->auth->attempt(['email' => $data['email'],'password' => $data['password'],'active' => 1]);
            if (!$token) {
                throw new AuthenticationException('invalid email or password');
            }
            $user = $this->userRepository->findById($this->auth->user()->id);
            $user->access_token = $token;
        });
        $resource = new UserResource($user);
        return response()->fetch(
            'Login Successful',
            $resource,
            'user'
        );
    }

    public function verifyUserEmail($user,$otp){
        
        $user_otp = DB::table('email_otp')->where('user_id',$user->id)->first()->otp;
        
        if($user_otp === $otp){
            $user->email_verified = 1;
            $user->save();
            $token = auth()->login($user);
            $user->access_token = $token;
            $resource = new UserResource($user);
            return response()->updated('user verified successfully',$resource,'user');
        }
        throw new CustomValidationFailed('the otp is invalid');

    }

    protected function sendVerificationEmail(object $user):void {
        $length = 5;
        $otp =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil
        ($length/strlen($x)) )),1,$length);
        DB::table('email_otp')->updateOrInsert(['user_id' => $user->id],[
            'id' => Uuid::uuid1(),
            'user_id' => $user->id,
            'otp' => $otp,
        ]);
        event(new AccountRegistered($user));
    }

    public function sendResetPasswordMail($email){
        $user = $this->user->where('email',$email)->first();
        event(new PasswordReset($user));
        return response()->created('password reset sent successfully', true,'reset');
    }

    public function resetPassword($user,$data){
        $password = Hash::make($data['password']);
        $user->password = $password;
        $user->save();
        $token = auth()->login($user);
        $user->access_token = $token;
        $resource = new UserResource($user);
        return response()->updated('Password Reset successfully',$resource,'user');
    }



}
