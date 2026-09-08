<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mail_campaign', function (Blueprint $table) {

            $table->enum('campaign_status',[
                'draft',
                'queued',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'active',
                'deleted',
            ])->default('draft')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
