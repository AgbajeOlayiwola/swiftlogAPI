<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_guarantors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('residential_address');
            $table->string('telephone');
            $table->string('residential_office_address');
            $table->string('drivers_license');
            $table->string('passport');
            $table->uuid('rider_id');
            $table->foreign('rider_id')
                ->references('id')
                ->on('riders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('rider_guarantors');
    }
}
