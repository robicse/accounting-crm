<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_sale_detail_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->integer('created_user_id');
            $table->string('status')->nullable();
            $table->string('date');
            $table->timestamps();
            $table->foreign('product_sale_detail_id')->references('id')->on('product_sale_details')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_services');
    }
}
