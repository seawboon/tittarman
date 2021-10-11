<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressColsToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->longText('gps')->nullable()->after('short');
            $table->longText('address')->nullable()->after('short');
            $table->longText('operating_hours')->nullable()->after('short');
            $table->longText('phone')->nullable()->after('short');
            $table->longText('title')->nullable()->after('short');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
          $table->dropColumn('gps');
          $table->dropColumn('address');
          $table->dropColumn('operating_hours');
          $table->dropColumn('phone');
          $table->dropColumn('title');
        });
    }
}
