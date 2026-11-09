<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('user_id');
            $table->integer('rating');
            $table->text('body')->nullable();
            $table->string('status', 50)->default('pending');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('estimate_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name');
            $table->json('parameters')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('estimate_items', function (Blueprint $table) {
            $table->increments('estimate_item_id');
            $table->unsignedInteger('estimate_id');
            $table->unsignedInteger('product_id')->nullable();
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->string('unit', 50)->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('line_total', 10, 2);

            $table->foreign('estimate_id')
                ->references('estimate_id')
                ->on('estimates')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('set null');
        });

        Schema::create('external_auth_accounts', function (Blueprint $table) {
            $table->increments('external_auth_account_id');
            $table->unsignedInteger('user_id');
            $table->string('provider', 50);
            $table->string('provider_user_id');
            $table->dateTime('created_at')->useCurrent();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_auth_accounts');
        Schema::dropIfExists('estimate_items');
        Schema::dropIfExists('estimates');
        Schema::dropIfExists('reviews');
    }
};