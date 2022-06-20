<?php
namespace App\Providers;

use App\Services\Interfaces\SmsServiceInterface;
use App\Services\SmsServices;
use Illuminate\Support\ServiceProvider;

class ExternalServicesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot()
    {
        /**Register Observer Models **/

        # register the routes

    }

    public function register()
    {
        //
        $this->app->bind(
            SmsServiceInterface::class,
            SmsServices::class
        );
    }
}
