<?php


namespace App\Providers;

use App\Repositories\CouponRepository;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\OrderDestinationRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\OrderScheduleRepositoryInterface;
use App\Repositories\Interfaces\OtpRepositoriesInterface;
use App\Repositories\Interfaces\RiderGuarantorRepositoryInterface;
use App\Repositories\Interfaces\RiderRepositoryInterface;
use App\Repositories\Interfaces\TicketCategoryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\OrderDestinationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderScheduleRepository;
use App\Repositories\OtpRepository;
use App\Repositories\RiderGuarantorRepository;
use App\Repositories\RiderRepository;
use App\Repositories\TicketCategoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
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
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            OtpRepositoriesInterface::class,
            OtpRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            OrderScheduleRepositoryInterface::class,
            OrderScheduleRepository::class
        );

        $this->app->bind(
            OrderDestinationRepositoryInterface::class,
            OrderDestinationRepository::class
        );

        $this->app->bind(
            TicketCategoryRepositoryInterface::class,
            TicketCategoryRepository::class
        );

        $this->app->bind(
            CouponRepositoryInterface::class,
            CouponRepository::class
        );

        $this->app->bind(
            RiderRepositoryInterface::class,
            RiderRepository::class
        );

        $this->app->bind(
            RiderGuarantorRepositoryInterface::class,
            RiderGuarantorRepository::class
        );
    }
}
