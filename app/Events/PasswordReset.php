<?php

namespace App\Events;

use App\Models\User;
class PasswordReset extends Event
{


    /** @var User  */
    public $user;

    /**
     * AccountRegistered constructor.
     *
     * @param User         $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
