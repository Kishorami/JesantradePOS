<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoldordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holdorders', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('products');
            $table->string('bill_code');
            $table->integer('id_customer');
            $table->integer('id_seller');
            $table->string('tax');
            $table->integer('tax_percent');
            $table->string('net_price');
            $table->string('total_price');
            $table->longText('payment_method');
            $table->string('amount_paid');
            $table->string('amount_due');
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
        Schema::dropIfExists('holdorders');
    }
}
