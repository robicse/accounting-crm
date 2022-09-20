<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchaseReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_return_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_purchase_return_id')->unsigned();
            $table->bigInteger('product_purchase_detail_id')->unsigned();
            $table->integer('product_category_id');
            $table->integer('product_sub_category_id')->nullable();
            $table->integer('product_brand_id');
            $table->bigInteger('product_id')->unsigned();
            $table->integer('qty');
            $table->float('price',8,2);
            $table->longText('reason');
            $table->timestamps();
            $table->foreign('product_purchase_return_id')->references('id')->on('product_purchase_returns')->onDelete('cascade');
            $table->foreign('product_purchase_detail_id')->references('id')->on('product_purchase_details')->onDelete('cascade');
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
        Schema::dropIfExists('product_purchase_return_details');
    }
}
