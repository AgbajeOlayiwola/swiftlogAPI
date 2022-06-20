<?php

namespace App\Listeners;


use App\Adapter\Interfaces\SmsAdapterInterface;
use App\Events\AccountRegistered;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AccountRegisteredListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @param AccountRegistered $event
     */
    private $smsAdapter;

    public function __construct(SmsAdapterInterface $smsAdapter)
    {
        $this->smsAdapter = $smsAdapter;
    }

    public function handle(AccountRegistered $event)
    {
        Mail::to($event->user)->send(new WelcomeEmail($event->user));
    }
}
