<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_groups', function (Blueprint $table) {
            $table->foreign(
                'category_id',
                'contact_groups_category_id_fk'
            )
            ->references('id')
            ->on('contact_categories')
            ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('contact_groups', function (Blueprint $table) {
            $table->dropForeign('contact_groups_category_id_fk');
        });
    }
};


