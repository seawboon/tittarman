<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->double('total', 10, 2)->nullable();
            $table->double('percentage', 5, 2)->nullable();
            $table->double('sell', 10, 2)->nullable();
            $table->enum('status', ['yes', 'no']);
            $table->dateTime('publish_date_start');
            $table->dateTime('publish_date_end');
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
        Schema::dropIfExists('packages');
    }
}
