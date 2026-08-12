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
        Schema::create('contact_groups', function (Blueprint $table) {
            $table->id();

            $table->string('group_name', 25);

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('mail_campaign_categories')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('mail_campaign_footer')
                ->default(true)
                ->comment('1 = Yes, 0 = No');

            $table->boolean('status')
                ->default(true)
                ->comment('1 = Active, 0 = Inactive');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_groups');
    }
};