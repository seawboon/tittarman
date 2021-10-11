<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treat_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('treat_id');
            $table->unsignedBigInteger('matter_id');
            $table->unsignedBigInteger('patient_id');
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
        Schema::dropIfExists('treat_products');
    }
}
