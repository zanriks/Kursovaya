<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->foreign('parent_id')
                ->references('category_id')
                ->on('categories')
                ->onDelete('set null');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->unsignedInteger('category_id');
            $table->string('sku', 100)->unique();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('rating_cache', 3, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hit')->default(false);
            $table->unsignedInteger('created_by')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories');

            $table->foreign('created_by')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('product_specifications', function (Blueprint $table) {
            $table->increments('product_specification_id');
            $table->unsignedInteger('product_id');
            $table->string('name');
            $table->string('value');
            $table->integer('sort_order')->default(0);

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('product_image_id');
            $table->unsignedInteger('product_id');
            $table->string('image_url');
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};