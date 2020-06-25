<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMattersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('matters', function (Blueprint $table) {
          $table->dropColumn('injury_part');
          $table->longText('notes')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('matters', function (Blueprint $table) {
          $table->string('injury_part');
          $table->dropColumn('notes')->nullable();
      });
    }
}
