<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot(){
        /**Register Observer Models **/
        Schema::defaultStringLength(191);
        # register the routes
        $this->app['path.config'] = base_path('config');

    }
    public function register()
    {
        //

    }
}
