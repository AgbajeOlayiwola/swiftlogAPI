<?php
namespace App\Adapter\Interfaces;

use App\Models\User;

interface SmsAdapterInterface {
    public function SendOtp(string $otp, User $user);

    public function sendPassword(string $password, User $user);
}
