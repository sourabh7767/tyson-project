<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_data', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1=>trip,2=>standby,3=>meeting')->nullable();
            $table->integer('user_id');
            $table->time('total_hours')->nullable();
            $table->string('start_lat')->nullable();
            $table->string('start_long')->nullable();
            $table->string('start_address')->nullable();
            $table->string('end_lat')->nullable();
            $table->string('end_long')->nullable();
            $table->string('end_address')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
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
        Schema::dropIfExists('trip_data');
    }
}
