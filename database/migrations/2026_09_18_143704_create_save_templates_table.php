<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('save_templates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('template_title', 255)
                ->nullable();

            $table->longText('template_content')
                ->nullable();

            $table->string('session_id', 255)
                ->nullable();

            $table->enum('status', [
                'Active',
                'Deactive',
                'deleted',
            ])->default('Active');

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('save_templates');
    }
};