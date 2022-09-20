<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_sale_id')->unsigned();
            $table->enum('return_type',['returnable','not returnable']);
            $table->integer('product_category_id');
            $table->integer('product_sub_category_id')->nullable();
            $table->integer('product_brand_id');
            $table->bigInteger('product_id')->unsigned();
            $table->integer('qty');
            $table->float('price',8,2);
            $table->timestamps();
            $table->foreign('product_sale_id')->references('id')->on('product_sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sale_details');
    }
}
