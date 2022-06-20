<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_destinations', function (Blueprint $table) {
            $table->uuid('id')
                ->primary();
            $table->uuid('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('pickupAddress_text');
            $table->string('address_text');
            $table->string('address_lat');
            $table->string('address_lng');
            $table->string('item_name');
            $table->string('recipient_name');
            $table->string('recipient_telephone');
            $table->string('category')->nullable();
            $table->boolean('fragile');
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
        Schema::dropIfExists('order_destinations');
    }
}
