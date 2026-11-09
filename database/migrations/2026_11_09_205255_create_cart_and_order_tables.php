<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('cart_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('session_key')->nullable();
            $table->string('status', 50)->default('active');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->increments('cart_item_id');
            $table->unsignedInteger('cart_id');
            $table->unsignedInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_add', 10, 2);

            $table->foreign('cart_id')
                ->references('cart_id')
                ->on('carts')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('status', 50)->default('new');
            $table->string('customer_name');
            $table->string('email');
            $table->text('delivery_address');
            $table->text('comment')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('order_item_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id')->nullable();
            $table->string('product_name_snapshot');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};