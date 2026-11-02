<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->integer('package_emails')
                ->default(0)
                ->change();
        });

        Schema::table('user_email_usages', function (Blueprint $table) {
            $table->integer('email_limit')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->unsignedInteger('package_emails')
                ->default(0)
                ->change();
        });

        Schema::table('user_email_usages', function (Blueprint $table) {
            $table->unsignedInteger('email_limit')
                ->change();
        });
    }
};