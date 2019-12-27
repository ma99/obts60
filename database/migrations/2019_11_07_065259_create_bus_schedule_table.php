<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('schedule_id');            
            $table->unsignedBigInteger('route_id');            
            $table->timestamps();

            $table->foreign('bus_id')
                  ->references('id')->on('buses')
                  ->onDelete('cascade');            
            $table->foreign('schedule_id')
                  ->references('id')->on('schedules')
                  ->onDelete('cascade');
            // $table->foreign('route_id')
            //       ->references('id')->on('routes')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_schedule');
    }
}
