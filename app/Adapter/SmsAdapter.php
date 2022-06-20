<?php
namespace App\Adapter;

use App\Adapter\Interfaces\SmsAdapterInterface;
use App\Models\User;
use App\Services\Interfaces\SmsServiceInterface;

class SmsAdapter extends BaseFactory implements SmsAdapterInterface
{
    private $smsService;

    private $initiateServices;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function plug()
    {

    }

    public function SendOtp(string $otp, User $user) {
        $message = "Welcome to SWIFT LOGISTICS. Your verification otp is $otp.";
        $this->smsService->sendSms($message, $user->telephone);
    }

    public function sendPassword(string $password, User $user) {
        $message = "Welcome to SWIFT LOGISTICS. Your password is $password.";
        $this->smsService->sendSms($message, $user->telephone);
    }
}
