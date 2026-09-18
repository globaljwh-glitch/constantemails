<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bad_mail_list', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bad_mail_id')
                ->nullable()
                ->constrained('bad_mail_category')
                ->cascadeOnDelete();

            $table->string('first_name', 255)
                ->nullable();

            $table->string('last_name', 255)
                ->nullable();

            $table->string('company', 255)
                ->nullable();

            $table->string('address', 255)
                ->nullable();

            $table->string('email', 255)
                ->nullable();

            $table->string('phone', 11)
                ->nullable();

            $table->enum('status', ['y', 'n'])
                ->default('y');

            $table->timestamps();

            $table->index('bad_mail_id');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bad_mail_list');
    }
};