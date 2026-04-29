<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('brand')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('reviews_count')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('badge')->nullable(); // SALE, NEW, BESTSELLER
            $table->text('image_url'); // Main image
            $table->json('additional_images')->nullable(); // Array of extra image URLs
            $table->json('colors')->nullable(); // Array of color objects {name: 'Black', hex: '#000'}
            $table->json('sizes')->nullable(); // Array of strings ['XS', 'S', etc]
            $table->integer('stock')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
