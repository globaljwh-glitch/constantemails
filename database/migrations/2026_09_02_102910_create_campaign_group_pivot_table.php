<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_group', function (Blueprint $table) {

            $table->id();

            $table->foreignId('campaign_id')
                ->constrained('mail_campaign')
                ->cascadeOnDelete();

            $table->foreignId('group_id')
                ->constrained('contact_groups')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['campaign_id', 'group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_group');
    }
};