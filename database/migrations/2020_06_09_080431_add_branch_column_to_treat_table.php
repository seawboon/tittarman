<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchColumnToTreatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('treats', function (Blueprint $table) {
             $table->unsignedBigInteger('branch_id');
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
             $table->dropColumn('branch_id');
         });
     }
}
