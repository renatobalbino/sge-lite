<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            // Cores pré-definidas para o Tailwind (red, blue, emerald, zinc, purple)
            $table->string('color')->default('zinc');
            $table->timestamps();
        });

        Schema::create('product_tag', function (Blueprint $table) {
            $table->foreignUlid('product_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('tags');
    }
};
