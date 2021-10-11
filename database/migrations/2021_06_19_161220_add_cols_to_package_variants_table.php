<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToPackageVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_variants', function (Blueprint $table) {
            $table->double('sell')->after('sku');
            $table->double('price')->after('sku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_variants', function (Blueprint $table) {
          $table->dropColumn('price');
          $table->dropColumn('sell');
        });
    }
}
