<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('favorite_id');

            // В БД laravel users.user_id и products.product_id — int unsigned.
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('product_id');

            $table->dateTime('created_at')->useCurrent();

            $table->unique(['user_id', 'product_id']);

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
