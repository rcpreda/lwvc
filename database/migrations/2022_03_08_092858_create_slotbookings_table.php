<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotbookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slotbookings', function (Blueprint $table) {
            $table->increments('id');
            $table->BigInteger('user_id')->nullable();
            $table->BigInteger('event_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->longText('description')->nullable();
            $table->date('confirmdate')->nullable();
            $table->string('timezone')->nullable();
            $table->string('slot')->nullable();
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
        Schema::dropIfExists('slotbookings');
    }
}
