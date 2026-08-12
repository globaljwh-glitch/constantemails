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
        Schema::create('registration_packages', function (Blueprint $table) {

            $table->id();

            $table->string('package_name');

            $table->decimal('package_price', 10, 2)->nullable();

            $table->unsignedInteger('package_emails')->default(0);

            // Duration in days
            $table->unsignedInteger('duration')->default(0);

            $table->enum('access_level', [
                'admin',
                'user',
            ])->default('user');

            $table->enum('status', [
                'Active',
                'Deactive',
                'Deleted',
            ])->default('Active');

            $table->timestamps();

            $table->index('access_level');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_packages');
    }
};