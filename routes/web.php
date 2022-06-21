<?php
use Illuminate\Support\Facades\Route;

Route::get('',function (){
    return 'Welcome to Swift Logistics Api';
});

Route::group(['prefix' => 'api/v1'],function () {
    Route::get('',function (){
        return 'Welcome to Swift Logistics Api';
    });

    
    Route::post('bikes', 'RiderController@fetchAllBikes');

    Route::post('settings', 'RiderController@updateSettings');
    Route::get('settings', 'RiderController@allSettings');
    Route::get('dashboard', 'RiderController@dashbaord');
    Route::get('active-riders', 'RiderController@activeriders');
    Route::post('assign-rider', 'RiderController@orderToRider');
    Route::get('ticketall', 'TicketController@all');
    Route::post('rate-order', 'RiderController@rate');
    Route::post('bike', 'RiderController@createBike');
    Route::post('edit-bike', 'RiderController@editBike');
    Route::post('couponadd', 'UserController@addCoupon');
    Route::get('usercoupon', 'UserController@getUserCoupon');

    Route::group(['prefix' => 'authentication'],function (){
        Route::post('/login','Auth\AuthController@login');
        Route::post('/register','Auth\AuthController@register');
        Route::post('/register/member','Auth\AuthController@registerMember');
        Route::post('/member','Auth\AuthController@registerMember');
        Route::post('/password/reset/mail','Auth\AuthController@resetPasswordMail');
        Route::post('/mail/resend','Auth\AuthController@resendVerification');
        Route::get('token', 'Auth\AuthController@checkToken');
    });
    Route::get('/otp/request','Auth\AuthController@otp');

    Route::group(['prefix' => 'orders'], function () {
        Route::get('orderList','OrderController@fetchOrder');
        Route::get('orderList/{id}','OrderController@fetchOrderid');
        Route::get('/track/{orderId}', 'OrderController@fetch');
        Route::get('userorder', 'OrderController@userorder');
        Route::get('', 'OrderController@all');
        Route::put('/{orderId}', 'OrderController@update');
        Route::post('/schedule', 'OrderController@schedule');
        Route::post('calculate/distance', 'OrderController@distance');
    });

    Route::group(['middleware' => ['auth:api']], function (){
        Route::post('/verify','Auth\AuthController@userVerification');
        Route::get('/verify/allotp', 'Auth\AuthController@allOtp');
        Route::get('/request/otp','Auth\AuthController@otp');
        Route::put('/password/reset','Auth\AuthController@passwordReset');
        Route::group(['prefix' => 'user'], function () {
            Route::get('count/{userType}', 'UserController@count');
            Route::get('admin', 'UserController@admin');
            Route::get('all', 'UserController@users');
            Route::post('profile', 'UserController@update');
            Route::post('block', 'UserController@block');
            Route::put('password', 'UserController@changePassword');
            Route::post('register','Auth\AuthController@register');
            // Route::post('sendOtp', 'UserController@sendOtp');
        });

        // Route::group(['prefix' => 'orders'], function () {

        //     Route::get('/{orderId}', 'OrderController@fetch');
        //     // Route::get('user', 'OrderController@user');
        //     Route::get('', 'OrderController@all');
        //     Route::get('delete/all/user/{userId}', 'UserController@deleteOrders');
        //     Route::post('/{orderId}', 'OrderController@update');
        //     // Route::post('', 'OrderController@create');
        //     Route::post('/schedule', 'OrderController@schedule');
        //     Route::post('calculate/distance', 'OrderController@distance');
        // });

        Route::group(['prefix' => 'todo'], function () {
            Route::post('', 'TicketController@todoCreate');
            Route::get('', 'TicketController@todoAll');
            Route::get('{todoId}', 'TicketController@deleteTo');
            Route::get('/star/{todoId}', 'TicketController@starTod');
        });

        Route::group(['prefix' => 'coupon'], function () {
            Route::post('', 'CouponController@create');
            Route::get('', 'CouponController@all');
            Route::post('{couponId}', 'CouponController@edit');
        });

        Route::group(['prefix' => 'ticket'], function () {
            Route::get('', 'TicketController@all');
            Route::post('', 'TicketController@createUser');
            Route::group(['prefix' => 'category'], function () {
                Route::get('', 'TicketController@categories');
                Route::post('', 'TicketController@createCategories');
            });
        });

        Route::group(['prefix' => 'rider'], function () {
            Route::get('', 'RiderController@all');
            Route::post('', 'UserController@registerRider');

        });
    });
});