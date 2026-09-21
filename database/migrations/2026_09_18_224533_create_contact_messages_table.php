<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email', 255);
            $table->string('organization', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('comments');

            $table->enum('status', [
                'new',
                'read',
                'replied',
                'closed',
            ])->default('new');

            $table->timestamp('replied_at')->nullable();

            $table->timestamps();

            $table->index(['email', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};