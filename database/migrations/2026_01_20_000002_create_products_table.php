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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // O Tenant
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('slug')->index();
            $table->text('description')->nullable();

            // Preço base (em CENTAVOS para evitar erro de float). Ex: R$ 10,00 = 1000
            $table->integer('price')->default(0);

            // Controle simples: Se false, o produto "pai" não vende, só as variações
            $table->boolean('has_variants')->default(false);

            // Para ordenação visual no catálogo
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Importante para não quebrar histórico de pedidos
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
