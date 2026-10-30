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
        Schema::create('user_email_usages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('package_id')->nullable();

            // Package limit captured at the beginning of this cycle
            $table->unsignedInteger('email_limit');

            // Successfully accepted by SMTP
            $table->unsignedInteger('emails_sent')->default(0);

            // Credits reserved for queued campaign recipients
            $table->unsignedInteger('emails_reserved')->default(0);

            $table->timestamp('period_started_at')->nullable();
            $table->timestamp('period_ends_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'period_ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_email_usages');
    }
};
