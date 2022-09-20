<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voucher_type_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('date')->nullable();
            $table->integer('account_id');
            $table->string('account_name')->nullable();
            $table->string('parent_account_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_type')->nullable();
            $table->float('debit',32,2);
            $table->float('credit',32,2)->nullable();
            $table->text('transaction_description')->nullable();
            $table->string('bank_user')->nullable();
            $table->string('created_date_time')->nullable();
            $table->string('is_approved')->default('pending');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('postings');
    }
}
