<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('vouchers', function (Blueprint $table) {
          $table->unsignedBigInteger('owner_id')->nullable();
          $table->string('transfer')->nullable()->comment('yes / no');
          $table->dateTime('transfer_date')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('vouchers', function (Blueprint $table) {
          $table->dropColumn('owner_id');
          $table->dropColumn('transfer');
          $table->dropColumn('transfer_date');
      });
    }
}
