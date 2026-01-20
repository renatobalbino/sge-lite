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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Nome composto para facilitar o display no carrinho. Ex: "G / Azul"
            $table->string('name');

            // SKU para controle interno do lojista (Opcional, mas útil)
            $table->string('sku')->nullable();

            // Preço específico da variação. Se NULL, usa o preço do Pai.
            $table->integer('price')->nullable();

            // Preço promocional (De/Por)
            $table->integer('promotional_price')->nullable();

            // Estoque real desta variação
            $table->integer('stock_quantity')->default(0);

            // JSON para guardar os detalhes técnicos sem criar tabelas extras
            // Ex: {"cor": "#FF0000", "tamanho": "G", "tecido": "Algodão"}
            $table->json('properties')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
