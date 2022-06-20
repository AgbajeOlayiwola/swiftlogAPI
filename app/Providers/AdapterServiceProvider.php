<?php
namespace App\Providers;

use App\Adapter\Interfaces\SmsAdapterInterface;
use App\Adapter\SmsAdapter;
use Illuminate\Support\ServiceProvider;

class AdapterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**Register Observer Models **/

        # register the routes

    }

    public function register()
    {
        //
        $this->app->bind(
            SmsAdapterInterface::class,
            SmsAdapter::class
        );
    }
}
