<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('salutation')->nullable();
            $table->string('fullname');
            $table->string('nric')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('occupation')->nullable();
            $table->string('gender');
            $table->longText('address')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
