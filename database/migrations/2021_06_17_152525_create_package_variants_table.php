<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('package_id')->index();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->unique();
            $table->unsignedBigInteger('stock')->nullable();
            $table->longText('remark')->nullable();
            $table->enum('status', ['yes', 'no']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_variants');
    }
}
