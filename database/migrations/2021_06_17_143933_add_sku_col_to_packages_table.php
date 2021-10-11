<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkuColToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('sku')->unique()->after('slug');
            $table->longText('remark')->nullable()->after('description');
            $table->dropColumn('total');
            $table->dropColumn('percentage');
            $table->dropColumn('sell');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('remark');
            $table->double('total', 10, 2)->nullable()->after('image_url');
            $table->double('percentage', 5, 2)->nullable()->after('image_url');
            $table->double('sell', 10, 2)->nullable()->after('image_url');
        });
    }
}
