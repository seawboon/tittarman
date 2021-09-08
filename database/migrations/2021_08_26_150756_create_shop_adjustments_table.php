<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_adjustments', function (Blueprint $table) {
          $table->increments('id');

          $table->uuid('shop_order_uuid')->nullable();
          $table->unsignedInteger('shop_order_items_id')->nullable();
          $table->unsignedInteger('shop_order_item_unit_id')->nullable();

          $table->string('type')->nullable()->comment('调整的类型 shipping/promotion/tax等等');

          $table->string('label')->nullable()->comment('结合type决定');

          $table->string('origin_code')->nullable()->comment('结合label决定');

          $table->boolean('included')->comment('是否会影响最终订单需要支付的价格');
          $table->integer('amount')->nullable();
          $table->timestamps();

          $table->index('shop_order_uuid');
          $table->index('shop_order_items_id');
          $table->index('shop_order_item_unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_adjustments');
    }
}
