<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVaraintIdColToPatientVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->index()->after('patient_package_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_vouchers', function (Blueprint $table) {
            $table->dropColumn('variant_id');
        });
    }
}
