<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatDrugPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treat_drug_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('treatdrug_id');
            $table->foreign('treatdrug_id')->references('id')->on('treat_drugs')->onDelete('cascade');
            $table->unsignedBigInteger('part_id');
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
        Schema::dropIfExists('treat_drug_parts');
    }
}
