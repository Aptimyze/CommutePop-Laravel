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
            $table->integer('user_id')->unsigned();
            $table->string('email', 255);
            $table->string('stop', 5);
            $table->string('route', 4);
            $table->string('departure_time', 22);
            $table->integer('time_to_stop')->unsigned();
            $table->integer('lead_time')->unsigned();
            $table->time('alert_time');
            $table->date('last_sent');
            $table->string('timezone', 20);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
