<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMattersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matters', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('patient_id');
          $table->string('injury_part');
          $table->date('injury_since')->nullable();
          $table->longText('remarks')->nullable();
          $table->string('sensitive_skin');
          $table->longText('comments')->nullable();
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
        Schema::dropIfExists('matters');
    }
}
