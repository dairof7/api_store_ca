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
            $table->id(); // ID autogenerado
            $table->string('name'); // Nombre del producto
            $table->text('description')->nullable(); // Descripción, puede ser nula
            $table->decimal('price', 8, 2); // Precio con 8 dígitos en total y 2 decimales
            $table->string('category'); // Categoría del producto
            $table->timestamps(); // created_at y updated_at automáticos
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
