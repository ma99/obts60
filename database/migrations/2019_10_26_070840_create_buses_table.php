<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->unsignedBigInteger('seat_plan_id');            
            $table->string('reg_no');
            $table->string('number_plate');
            $table->enum('type', ['ac', 'ac-deluxe', 'deluxe', 'non-ac']);
            $table->text('description')->nullable();           
            $table->timestamps();

            $table->foreign('seat_plan_id')
                  ->references('id')->on('seat_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
}
