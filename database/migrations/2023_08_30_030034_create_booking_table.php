<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('slot_id');
            $table->integer('user_id');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('csr_name');
            $table->string('customer_name')->nullable();
            $table->dateTime('time_of_booking');
            $table->string('job_number');
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
        Schema::dropIfExists('booking');
    }
}
