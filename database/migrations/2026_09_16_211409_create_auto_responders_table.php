<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autoresponders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('subject', 255);

            $table->string('sender_name', 255);

            $table->string('auto_responder_name', 255);

            $table->enum('creation_type', [
                'new',
                'copy'
            ])->default('new');

            $table->foreignId('campaign_id')
                ->nullable()
                ->constrained('mail_campaign')
                ->nullOnDelete();

            $table->text('message')->nullable();

            $table->string('attachment')->nullable();

            $table->enum('status', [
                'draft',
                'active',
                'paused',
                'completed',
                'deleted'
            ])->default('draft');

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autoresponders');
    }
};