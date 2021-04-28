<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeToPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treats', function (Blueprint $table) {
            $table->foreign('matter_id')->references('id')->on('matters')->onDelete('cascade')->change();
        });

        Schema::table('matters', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('treats', function (Blueprint $table) {
              $table->dropForeign(['matter_id']);
        });

        Schema::table('matters', function (Blueprint $table) {
              $table->dropForeign(['patient_id']);
        });
    }
}
