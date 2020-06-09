<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('patients', function (Blueprint $table) {
          $table->string('provider')->nullable();
          $table->longText('address2');
          $table->string('postcode');
          $table->string('state');
          $table->string('country');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('patients', function (Blueprint $table) {
          $table->dropColumn('provider');
          $table->dropColumn('address2');
          $table->dropColumn('postcode');
          $table->dropColumn('state');
          $table->dropColumn('country');
      });
    }
}
