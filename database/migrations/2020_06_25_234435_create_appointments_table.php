<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('matter_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('salutation')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('provider');
            $table->string('contact');
            $table->dateTime('appointment_date');
            $table->string('state')->default('awaiting')->comment('awaiting / cancelled / checkin');
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
        Schema::dropIfExists('appointments');
    }
}
