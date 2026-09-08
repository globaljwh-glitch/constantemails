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
        Schema::create('campaign_recipients', function (Blueprint $table) {

            $table->id();

            $table->foreignId('campaign_id')
                ->constrained('mail_campaign')
                ->cascadeOnDelete();

            $table->foreignId('contact_id')
                ->nullable()
                ->constrained('contact_lists')
                ->nullOnDelete();

            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->enum('status',[
                'queued',
                'sending',
                'sent',
                'failed',
                'bounced',
                'opened',
                'clicked',
                'unsubscribed',
            ])->default('queued');

            $table->text('error_message')->nullable();

            $table->timestamp('queued_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();

            $table->timestamps();

            $table->index(['campaign_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_recipients');
    }
};
