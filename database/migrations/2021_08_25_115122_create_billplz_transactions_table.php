<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillplzTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billplz_transactions', function (Blueprint $table) {
          $table->id();
          $table->uuid('uuid')->unique()->index();
          $table->string('bill_id');
          $table->text('bill_url')->nullable();
          $table->string('collection_id');
          $table->boolean('paid')->default(false)->comment('true, false');
          $table->string('state')->comment('due, paid and deleted');
          $table->uuid('shop_order_uuid')->index();
          $table->unsignedInteger('market_source_id')->default(0)->comment('market source');
          //$table->foreign('shop_order_uuid')->references('uuid')->on('shop_orders')->onDelete('cascade')->change();
          $table->string('currency_code', 3)->comment('冗余 货币编码');
          $table->unsignedInteger('amount')->default(0)->comment('支付金额');
          $table->unsignedInteger('paid_amount')->default(0)->comment('已支付金额');
          $table->string('email')->nullable();
          $table->string('mobile')->nullable();
          $table->string('name')->nullable();
          $table->text('redirect_url')->nullable();
          $table->text('callback_url')->nullable();
          $table->longText('description')->nullable();
          $table->string('x_signature')->nullable();
          $table->timestamp('paid_at')->nullable();
          $table->Date('due_at')->nullable();
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
        Schema::dropIfExists('billplz_transactions');
    }
}
