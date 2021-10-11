<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_promotions', function (Blueprint $table) {
          $table->increments('id');
          $table->string('code');

          $table->string('name')->nullable();
          $table->string('description')->nullable();
          $table->string('cover')->nullable()->comment('促销封面');
          $table->string('asset_url')->nullable()->comment('促销详情链接');

          $table->integer('position')->default(0)->comment('权重');
          $table->string('type')->comment('优惠卷/满减促销/品牌促销/秒杀/拼团/通用.');

          $table->json('config')->nullable()->comment('配置');

          $table->timestamp('began_at')->nullable()->comment('促销开始时间');
          $table->timestamp('ended_at')->nullable()->comment('促销结束时间');
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
        Schema::dropIfExists('shop_promotions');
    }
}
