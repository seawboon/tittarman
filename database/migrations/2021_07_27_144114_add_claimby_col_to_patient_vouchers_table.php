<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClaimbyColToPatientVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('use_in_payment')->nullable()->after('state');
            $table->unsignedBigInteger('claim_by')->nullable()->after('state');
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
            $table->dropColumn('claim_by');
            $table->dropColumn('use_in_payment');
        });
    }
}
