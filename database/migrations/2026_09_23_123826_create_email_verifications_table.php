<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();

            $table->string('domain')->nullable();

            $table->enum('status', [
                'valid',
                'invalid',
                'unknown',
            ])->default('unknown');

            $table->enum('smtp_status', [
                'accepted',
                'rejected',
                'temporary',
                'connection_failed',
                'timeout',
                'unknown',
                'not_checked',
            ])->default('not_checked');

            $table->boolean('syntax_valid')->default(false);
            $table->boolean('domain_exists')->default(false);
            $table->boolean('mx_exists')->default(false);

            $table->string('mx_host')->nullable();

            $table->unsignedSmallInteger('smtp_code')->nullable();

            $table->text('message')->nullable();

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index(['status']);
            $table->index(['domain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verifications');
    }
};