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
        Schema::create('quotes', function (Blueprint $table) {
            $table->ulid('id')->primary(); // URL-friendly ID

            // Relacionamento com o Dono (SaaS Tenant)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Dados do Cliente (Numa v2, pode ser uma foreignId 'client_id')
            // Mantemos string agora para permitir orçamentos rápidos sem cadastro prévio
            $table->string('client_name');
            $table->string('client_email')->nullable();

            // Detalhes do Orçamento
            $table->string('title'); // Ex: "Consultoria de Marketing" ou "Troca de Piso"
            $table->string('status')->default('draft')->index(); // draft, sent, approved, rejected

            // Valores
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Datas
            $table->date('valid_until')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('accepted_at')->nullable();

            // Campo Mágico para "Genérico"
            // Aqui guardamos os itens (linhas do orçamento) em JSON para não criar
            // uma tabela extra 'quote_items' agora. Isso facilita a prototipagem rápida.
            $table->json('items')->nullable();

            // Campos extras (Ex: Termos e Condições, notas privadas)
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
