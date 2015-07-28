<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('owner', 22)->nullable();
            $table->string('stop', 5);
            $table->string('route', 4);
            $table->time('departure_time');
            $table->time('time_to_stop');
            $table->time('lead_time');
            $table->time('alert_time');
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
        Schema::drop('alerts');
    }
}
