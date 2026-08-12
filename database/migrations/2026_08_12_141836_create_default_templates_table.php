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
        Schema::create('default_templates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('campaign_category_id')
                ->nullable()
                ->constrained('mail_campaign_categories')
                ->nullOnDelete();

            $table->string('template_name', 200);

            $table->longText('template_content')->nullable();

            $table->string('template_image', 500)->nullable();

            $table->enum('status', [
                'Active',
                'Deactive',
                'Deleted'
            ])->default('Active');

            $table->timestamps();

            $table->index('campaign_category_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_templates');
    }
};