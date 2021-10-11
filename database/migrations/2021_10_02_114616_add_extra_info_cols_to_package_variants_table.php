<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraInfoColsToPackageVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('package_variants', function (Blueprint $table) {
          $table->string('title')->nullable()->after('sku');
          $table->longText('description')->nullable()->after('remark');
          $table->longText('will_get')->nullable()->after('remark');
          $table->longText('redeem')->nullable()->after('remark');
          $table->longText('tnc')->nullable()->after('remark');
          $table->string('banner_image')->nullable()->after('remark');
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
          $table->dropColumn('title');
          $table->dropColumn('description');
          $table->dropColumn('will_get');
          $table->dropColumn('redeem');
          $table->dropColumn('tnc');
          $table->dropColumn('banner_image');
      });
    }
}
