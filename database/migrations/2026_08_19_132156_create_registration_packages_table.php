<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registration_packages', function (Blueprint $table) {
            $table->id(); // bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT
            $table->string('package_name', 255);
            $table->decimal('package_price', 10, 2)->nullable();
            $table->unsignedInteger('package_emails')->default(0);
            $table->unsignedInteger('duration')->default(0);
            $table->enum('access_level', ['admin', 'user'])->default('user');
            $table->enum('status', ['Active', 'Deactive', 'Deleted'])->default('Active');
            $table->timestamps(); // created_at and updated_at
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