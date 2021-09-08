<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCustomerUuidToPatientUuidFromShopOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropForeign(['customer_uuid']);
            $table->renameColumn('customer_uuid', 'patient_uuid');
            $table->foreign('patient_uuid')->references('uuid')->on('patients')->onDelete('cascade')->change();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropForeign(['customer_uuid']);
            $table->renameColumn('patient_uuid', 'customer_uuid');
            $table->foreign('customer_uuid')->references('uuid')->on('customers')->onDelete('cascade')->change();;
        });
    }
}
