<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payment_products', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('payment_id')->nullable();
          $table->unsignedBigInteger('treat_id')->nullable();
          $table->unsignedBigInteger('matter_id')->nullable();
          $table->unsignedBigInteger('patient_id')->nullable();
          $table->unsignedBigInteger('product_id');
          $table->double('price');
          $table->integer('unit');
          $table->double('total');
          $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('payment_products');
    }
}
