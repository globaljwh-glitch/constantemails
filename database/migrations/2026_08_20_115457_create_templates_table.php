<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            // Foreign key linking to template_categories table
            $table->foreignId('category_id')->constrained('template_categories')->onDelete('cascade');

            $table->string('name');
            $table->string('thumbnail')->nullable();
            $table->longText('content');
            $table->enum('status', ['Active', 'Deactive'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};