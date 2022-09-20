<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no');
            $table->integer('send_user_id');
            $table->string('send_date');
            $table->text('send_remarks')->nullable();
            $table->bigInteger('from_store_id')->unsigned();
            $table->bigInteger('to_store_id')->unsigned();
            $table->bigInteger('delivery_service_id')->unsigned()->nullable();
            $table->string('delivery_service_charge')->nullable();
            $table->enum('discount_type',['flat','percentage'])->nullable();
            $table->float('discount_amount', 8,2)->nullable();
            $table->float('total_amount', 8,2);
            $table->float('paid_amount', 8,2);
            $table->float('due_amount', 8,2);
            $table->integer('receive_user_id');
            $table->string('receive_date');
            $table->text('receive_remarks')->nullable();
            $table->enum('receive_status', ['pending','canceled','received']);
            $table->timestamps();
            $table->foreign('from_store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('to_store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('delivery_service_id')->references('id')->on('delivery_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_transfer');
    }
}
