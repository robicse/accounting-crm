<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_purchase_id')->unsigned();
            $table->integer('product_category_id');
            $table->integer('product_sub_category_id')->nullable();
            $table->integer('product_brand_id');
            $table->bigInteger('product_id')->unsigned();
            $table->integer('qty');
            $table->float('price',8,2);
            $table->float('mrp_price',8,2);
            $table->float('sub_total',8,2);
            $table->string('expired_date')->nullable();
            $table->timestamps();
            $table->foreign('product_purchase_id')->references('id')->on('product_purchases')->onDelete('cascade');
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
        Schema::dropIfExists('product_purchase_details');
    }
}
