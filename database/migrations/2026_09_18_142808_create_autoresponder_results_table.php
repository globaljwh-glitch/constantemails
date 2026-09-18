<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autoresponder_results', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Autoresponder
            |--------------------------------------------------------------------------
            */

            $table->foreignId('auto_id')
                ->constrained('autoresponders')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Contact Group
            |--------------------------------------------------------------------------
            */

            $table->foreignId('group_id')
                ->constrained('contact_groups')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Template
            |--------------------------------------------------------------------------
            */

            $table->text('template_id');


            /*
            |--------------------------------------------------------------------------
            | Recipient Snapshot
            |--------------------------------------------------------------------------
            */

            $table->text('contact_first_name');

            $table->text('contact_last_name');

            $table->foreignId('contact_id')
                ->nullable()
                ->constrained('contact_lists')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Schedule
            |--------------------------------------------------------------------------
            */

            $table->unsignedSmallInteger('interval');

            $table->dateTime('run_date_time');

            $table->dateTime('last_run_date_time');

            $table->dateTime('next_run_date_time');


            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            $table->foreignId('category_id')
                ->constrained('contact_categories')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Current Timestamp
            |--------------------------------------------------------------------------
            */

            $table->timestamp('current_date_time')
                ->useCurrent()
                ->useCurrentOnUpdate();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'auto_id',
                'group_id'
            ]);

            $table->index([
                'user_id',
                'next_run_date_time'
            ]);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('autoresponder_results');
    }
};