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
        Schema::table('campaign_recipients', function (Blueprint $table) {
            $table->unsignedBigInteger('quota_usage_id')->nullable();
            $table->timestamp('quota_counted_at')->nullable();
            $table->timestamp('quota_released_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_recipients', function (Blueprint $table) {
            $table->dropColumn([
                'quota_usage_id',
                'quota_counted_at',
                'quota_released_at',
            ]);
        });
    }

};
