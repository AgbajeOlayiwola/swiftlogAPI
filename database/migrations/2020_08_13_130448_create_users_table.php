<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('telephone');
            $table->string('business_category');
            $table->string('address_text')->nullable();
            $table->string('image_url')->nullable();
            $table->string('gender')->nullable();
            $table->string('position')->nullable();
            $table->string('address_latitude')->nullable();
            $table->string('address_longitude')->nullable();
            $table->enum('user_type', ['admin','super_admin','rider','customer'] );
            $table->boolean('email_verified')->default(0);
            $table->boolean('sms_otpVerified')->default(0);
            $table->boolean('active')->default(1);
            $table->dateTime('last_activity_entry')->default(\Carbon\Carbon::now());
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
