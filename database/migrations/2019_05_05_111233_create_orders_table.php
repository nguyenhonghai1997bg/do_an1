<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('paymethod_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paymethod_id')->references('id')->on('paymethods');
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
        Schema::dropIfExists('orders');
    }
}
