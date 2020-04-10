<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->unsignedBigInteger('booking_id');
            $table->string('transaction_id')->nullable();
            $table->float('amount', 8, 2);
            $table->string('currency', 10)->nullable($value = true); 
            $table->enum('method', ['cash', 'card', 'pos'])->default('card');
            //$table->text('payment_data')->nullable();
            //$table->text('validation_data')->nullable();
            //$table->dateTime('validation_date')->nullable();
            $table->string('status', 10)->default('Pending');           
            //$table->dateTime('edit_date');
            $table->string('received_by')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
