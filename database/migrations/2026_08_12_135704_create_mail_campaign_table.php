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
        Schema::create('mail_campaign', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->unsignedBigInteger('template_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();

            $table->string('group_id')->nullable();

            $table->string('email_title')->nullable();
            $table->string('from_name')->nullable();
            $table->string('email_subject')->nullable();

            $table->text('additional_recipients')->nullable();

            $table->longText('message')->nullable();
            $table->longText('mail_header')->nullable();
            $table->longText('mail_message')->nullable();

            $table->boolean('campaign_footer')->default(true);

            $table->enum('scheduler', [
                'send_now',
                'schedule_now'
            ])->nullable();

            $table->date('schedule_date')->nullable();
            $table->unsignedTinyInteger('schedule_hour')->nullable();
            $table->unsignedTinyInteger('schedule_minute')->nullable();

            $table->boolean('save_option')->default(false);

            $table->boolean('send_status')->default(false);

            $table->enum('campaign_status', [
                'active',
                'deleted'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_campaign');
    }
};