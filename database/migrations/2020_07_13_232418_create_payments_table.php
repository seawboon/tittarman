<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('matter_id')->nullable();
            $table->unsignedBigInteger('treat_id')->nullable();
            $table->double('treatment_fee')->default('0');
            $table->double('product_amount')->default('0');
            $table->double('discount')->default('0');
            $table->string('discount_code')->nullable();
            $table->double('total')->default('0');
            $table->string('state')->default('pay')->comment('pay / cancel / refund / paid');
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
        Schema::dropIfExists('payments');
    }
}
