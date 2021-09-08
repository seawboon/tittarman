<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromotionRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_promotion_rules', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('promotion_id');
          $table->string('type');
          $table->json('config')->nullable();
          $table->timestamps();

          $table->index('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_promotion_rules');
    }
}
