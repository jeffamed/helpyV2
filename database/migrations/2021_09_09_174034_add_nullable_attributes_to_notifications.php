<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableAttributesToNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('event')->nullable()->change();
            $table->integer('activity_id')->nullable()->change();
            $table->integer('ticket_id')->nullable()->change();
            $table->string('notify_to')->nullable()->change();
            $table->integer('ticket_by')->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('event')->change();
            $table->integer('activity_id')->change();
            $table->integer('ticket_id')->change();
            $table->string('notify_to')->change();
            $table->integer('ticket_by')->change();
        });
    }
}
