<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemoColToTreatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treats', function (Blueprint $table) {
            $table->longText('memo')->nullable()->after('remarks');
            $table->enum('guasha', ['yes', 'no'])->default('no')->after('treatment');
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
            $table->dropColumn('memo');
            $table->dropColumn('guasha');
        });
    }
}
