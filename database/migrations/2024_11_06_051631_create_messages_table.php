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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('message')->nullable();
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('receiver_id')->nullable()->constrained('users');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('conversation_id')->nullable()->constrained('conversations');
            $table->timestamps();
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreign('last_message_id')->references('id')->on('messages')->onDelete('set null');
        });
    
        Schema::table('conversations', function (Blueprint $table) {
            $table->foreign('last_message_id')->references('id')->on('messages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['last_message_id']);
        });
    
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['last_message_id']);
        });
    
        Schema::dropIfExists('messages');
    }
};
