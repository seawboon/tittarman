<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('images', function (Blueprint $table) {
           $table->unsignedBigInteger('matter_id')->nullable()->change();
           $table->unsignedBigInteger('treat_id')->nullable();
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::table('images', function (Blueprint $table) {
           $table->unsignedBigInteger('matter_id')->change();
           $table->dropColumn('treat_id');
       });
     }
}
