<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->text('detail');
            $table->boolean('status')->default(true);
            $table->integer('price');
            $table->integer('view')->default(0);
            $table->string('slug');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('sale_id')->nullable();

            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('sale_id')->references('id')->on('sales');
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
        Schema::dropIfExists('products');
    }
}
