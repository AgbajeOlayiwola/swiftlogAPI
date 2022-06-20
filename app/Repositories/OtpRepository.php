<?php


namespace App\Repositories;


use App\Models\Otp;
use App\Models\User;
use App\Repositories\Interfaces\OtpRepositoriesInterface;
use Illuminate\Database\Eloquent\Model;

class OtpRepository extends BaseRepository implements OtpRepositoriesInterface
{
    public function __construct(Otp $model)
    {
        parent::__construct($model);
    }

    public function create(object $user, string $otp): Otp
    {
        return Otp::create([
            'user_id' => $user->id,
            'otp' => $otp
        ]);
    }

    public function update(object $user, string $otp): Otp
    {
        return Otp::updateOrInsert(['user_id' => $user->id],[
            'user_id' => $user->id,
            'otp' => $otp
        ]);
    }

    public function checkForExisting(object $user): bool
    {
        return !is_null(Otp::where('user_id', $user->id)->first());
    }
}
