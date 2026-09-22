<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->timestamp('submittedAt')
                ->useCurrent();

            $table->string('refereEmail', 50);

            /*
             * 0 = Pending
             * 1 = Registered
             * 2 = Completed
             */
            $table->unsignedBigInteger('referred_user_id')
                ->default(0);

            $table->unsignedInteger('Status')
                ->default(0);

            $table->index('user_id');
            $table->index('refereEmail');
            $table->index('referred_user_id');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};