<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_shipments', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('method_id')->comment('运输方式 外键');
          $table->uuid('shop_order_uuid')->comment('订单 外键');
          $table->string('state')->comment('运输状态');
          $table->string('tracking_number')->nullable()->comment('订单号码');
          $table->timestamps();
          $table->index('shop_order_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_shipments');
    }
}
