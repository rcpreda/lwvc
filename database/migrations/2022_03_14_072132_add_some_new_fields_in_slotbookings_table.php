<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeNewFieldsInSlotbookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slotbookings', function (Blueprint $table) {
             $table->string('calendar_type')->nullable()->after('slot');
             $table->string('reminder_before')->nullable()->after('calendar_type');
             $table->string('reminder_notify_by')->nullable()->after('reminder_before');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slotbookings', function (Blueprint $table) {
            $table->dropColumn('calendar_type');
            $table->dropColumn('reminder_before');
            $table->dropColumn('reminder_notify_by');
        });
    }
}
