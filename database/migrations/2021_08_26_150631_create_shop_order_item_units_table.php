<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrderItemUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_item_units', function (Blueprint $table) {
          $table->increments('id');
            $table->unsignedInteger('shop_order_items_id')->index();
            $table->unsignedInteger('shipment_id')->default(0);
            $table->integer('adjustments_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_item_units');
    }
}
