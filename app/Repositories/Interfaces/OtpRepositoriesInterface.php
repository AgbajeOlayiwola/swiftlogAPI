<?php
namespace App\Repositories\Interfaces;

use App\Models\Otp;
use App\Models\User;

interface OtpRepositoriesInterface {
    public function checkForExisting(object $user): bool;

    public function create(object $user, string $otp): Otp;

    public function update(object $user, string $otp): Otp;
}
