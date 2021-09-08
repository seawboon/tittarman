<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromotionVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_promotion_variants', function (Blueprint $table) {
          $table->increments('id');

          $table->unsignedInteger('variant_id')->index();
          $table->unsignedInteger('promotion_id')->index();

          $table->decimal('discount_rate')->nullable()->comment('折扣率, 值为0.3表示打7折');
          $table->unsignedInteger('stock')->nullable()->comment('促销库存');
          $table->unsignedInteger('sold')->default(0)->comment('销售数量');
          $table->unsignedInteger('quantity_limit')->nullable()->comment('购买数量限制');
          $table->boolean('enabled')->default(1)->comment('启用');

          // 冗余
          $table->unsignedInteger('product_id');
          $table->string('promotion_type')->comment('冗余promotion表type');
          $table->json('rest')->nullable()->comment('冗余');

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
        Schema::dropIfExists('shop_promotion_variants');
    }
}
