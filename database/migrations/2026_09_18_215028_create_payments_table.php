<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('payment_type', [
                'registration',
                'upgrade',
            ])->nullable();

            $table->string('payment_price', 10)
                ->nullable();

            $table->date('payment_date')
                ->nullable();

            $table->string('subscription_id', 20)
                ->nullable();

            $table->enum('status', [
                'active',
                'deactive',
                'deleted',
            ])->nullable();

            $table->index(['user_id', 'status']);
            $table->index('subscription_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};