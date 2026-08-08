<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('discount', 5, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->json('sizes')->nullable();
            $table->string('badge')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->decimal('weight', 8, 2)->nullable();
            $table->foreignId('category_id')->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->fullText(['name', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
