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
        Schema::create('contact_lists', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('group_id')
                ->nullable()
                ->constrained('contact_groups')
                ->nullOnDelete();

            $table->string('contact_first_name')->nullable();
            $table->string('contact_last_name')->nullable();
            $table->string('contact_company_name')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('area_interest')->nullable();

            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 100)->nullable();

            $table->boolean('status')
                ->default(true)
                ->comment('1 = Active, 0 = Inactive');

            $table->enum('user_status', [
                'imported',
                'opt-in',
                'opt-out',
                'spam-marked',
            ])->default('opt-in');

            $table->timestamps();

            $table->index('contact_email');
            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_lists');
    }
};