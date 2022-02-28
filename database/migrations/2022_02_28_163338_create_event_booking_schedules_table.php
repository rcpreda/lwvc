<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBookingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_booking_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->BigInteger('user_id')->nullable();
            $table->BigInteger('event_id')->nullable();
            $table->string('checked_type')->nullable();
            $table->json('date_range')->nullable();
            $table->string('duration')->nullable();
            $table->string('before_event')->nullable();
            $table->json('availabledates')->nullable();
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
        Schema::dropIfExists('event_booking_schedules');
    }
}
