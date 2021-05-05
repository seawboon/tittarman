<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treat_drugs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('treat_id');
            $table->foreign('treat_id')->references('id')->on('treats')->onDelete('cascade');
            $table->unsignedBigInteger('drug_id');
            $table->unsignedBigInteger('quantity');
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
        Schema::dropIfExists('treat_drugs');
    }
}
