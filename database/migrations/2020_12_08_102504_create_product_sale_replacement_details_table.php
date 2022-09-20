<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSaleReplacementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale_replacement_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('p_s_replacement_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->string('replace_qty')->nullable();
            $table->float('price',8,2)->nullable();
            $table->longText('reason')->nullable();
            $table->foreign('p_s_replacement_id')->references('id')->on('product_sale_replacements')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_sale_replacement_details');
    }
}
