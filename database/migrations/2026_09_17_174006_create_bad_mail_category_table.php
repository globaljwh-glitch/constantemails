<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bad_mail_category', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('upload_date')
                ->nullable();

            $table->string('file_name', 255)
                ->nullable();

            $table->unsignedInteger('added')
                ->default(0);

            $table->unsignedInteger('rejected')
                ->default(0);

            $table->enum('status', ['y', 'n'])
                ->default('y');

            $table->timestamps();

            $table->index(['user_id', 'upload_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bad_mail_category');
    }
};