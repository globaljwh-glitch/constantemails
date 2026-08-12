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
        Schema::create('mail_campaign_contact_lists', function (Blueprint $table) {

            $table->id();

            $table->foreignId('mail_campaign_id')
                ->constrained('mail_campaign')
                ->cascadeOnDelete();

            $table->foreignId('contact_list_id')
                ->constrained('contact_lists')
                ->cascadeOnDelete();

            $table->enum('mail_status', [
                'pending',
                'sent'
            ])->default('pending');

            $table->enum('response_status', [
                'viewed',
                'bounced',
                'unsubscribed',
            ])->nullable();

            $table->unsignedInteger('forward_to_friend')->default(0);

            $table->boolean('opened')
                ->default(false)
                ->comment('0 = Unopened, 1 = Opened');

            $table->unsignedInteger('embed_link_clicks')->default(0);

            $table->enum('status', [
                'active',
                'deleted',
            ])->default('active');

            $table->enum('auto_responder_status', [
                'pending',
                'sent',
            ])->default('pending');

            $table->dateTime('sent_at')->nullable();

            $table->timestamps();

            $table->index('mail_campaign_id');
            $table->index('contact_list_id');
            $table->index('mail_status');
            $table->index('response_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_campaign_contact_lists');
    }
};