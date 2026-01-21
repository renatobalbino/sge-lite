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
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_instance_id')->nullable();
            $table->string('whatsapp_token')->nullable();
            $table->boolean('whatsapp_connected')->default(false);
        });

        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('remote_jid')->index();
            $table->string('customer_name')->nullable();
            $table->string('current_stage')->default('WELCOME');
            $table->json('context_data')->nullable();
            $table->timestamp('last_message_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_instance_id', 'whatsapp_token', 'whatsapp_connected']);
        });
        Schema::dropIfExists('chat_sessions');
    }
};
