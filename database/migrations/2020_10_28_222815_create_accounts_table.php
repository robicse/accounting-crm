<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ref_id')->nullable();
            $table->string('HeadCode')->nullable();
            $table->string('HeadName')->nullable();
            $table->string('PHeadName')->nullable();
            $table->string('BankUserAccount')->nullable();
            $table->integer('HeadLevel')->nullable();
            $table->string('IsActive')->nullable();
            $table->string('IsTransaction')->nullable();
            $table->string('IsGL')->nullable();
            $table->string('HeadType')->nullable();
            $table->string('CreateBy')->nullable();
            $table->string('UpdateBy')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
