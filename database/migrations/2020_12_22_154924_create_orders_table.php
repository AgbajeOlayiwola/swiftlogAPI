<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('destination');
            $table->string('address_text');
            $table->string('address_lat');
            $table->string('address_lng');
            $table->decimal('price', 13, 2);
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum(
                'status',
                [
                    'cancelled',
                    'rejected',
                    'pending',
                    'accepted',
                    'pick_up',
                    'picked_up',
                    'delivered'
                ]
            )->default('pending');
            $table->enum(
                'payment_method',
                [
                    'card',
                    'cash delivery',
                    'cash pickup'
                ]
            );
            $table->enum(
                'payment_status',
                [
                    'pending',
                    'successful'
                ]
            )->default('pending');
            $table->boolean('schedule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
