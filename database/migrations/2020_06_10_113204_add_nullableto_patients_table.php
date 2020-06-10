<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullabletoPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('patients', function (Blueprint $table) {
           $table->longText('address2')->nullable()->change();
           $table->string('postcode')->nullable()->change();
           $table->string('state')->nullable()->change();
           $table->string('country')->nullable()->change();
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
         $table->longText('address2')->change();
         $table->string('postcode')->change();
         $table->string('state')->change();
         $table->string('country')->change();
       });
     }
}
