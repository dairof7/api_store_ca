<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to create the 'products' table.
     *
     * This method defines the structure of the 'products' table:
     * - An auto-incrementing 'id' field
     * - A 'name' field for the product name (string)
     * - A 'description' field for the product description (nullable text)
     * - A 'price' field to store the product price (decimal with precision of 8 digits and 2 decimal places)
     * - A 'category' field to store the product's category (string)
     * - Timestamps for 'created_at' and 'updated_at' fields (automatically managed)
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID auto-incremented field
            $table->string('name'); // The name of the product
            $table->text('description')->nullable(); // The product's description (optional)
            $table->decimal('price', 8, 2); // Price of the product (with 8 digits in total and 2 decimal places)
            $table->string('category'); // Category of the product
            $table->timestamps(); // Automatically manage 'created_at' and 'updated_at' fields
        });
    }

    /**
     * Reverse the migrations by dropping the 'products' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
