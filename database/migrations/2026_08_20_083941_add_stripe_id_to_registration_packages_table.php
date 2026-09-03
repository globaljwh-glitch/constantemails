<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            // Adding stripe_id after package_name. It is nullable in case it's generated later.
            $table->string('stripe_id')->nullable()->after('package_name');
        });
    }

    public function down(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
        });
    }
};