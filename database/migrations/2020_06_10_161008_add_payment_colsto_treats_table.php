<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentColstoTreatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('treats', function (Blueprint $table) {
             $table->double('product_amount');
             $table->double('fee');
             $table->double('total');
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
             $table->dropColumn('product_amount');
             $table->dropColumn('fee');
             $table->dropColumn('product_amount');
         });
     }
}
