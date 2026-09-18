<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('autoresponders', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Old responder schedule
            |--------------------------------------------------------------------------
            */

            $table->dateTime('responder_date')
                ->nullable()
                ->after('attachment');


            /*
            |--------------------------------------------------------------------------
            | Contact Groups
            |--------------------------------------------------------------------------
            |
            | Kept for compatibility with the old application.
            | Actual group relationships can be handled through a pivot
            | table in the new Laravel implementation.
            |
            */

            $table->text('contact_groups')
                ->nullable()
                ->after('responder_date');

            $table->text('join_ids')
                ->nullable()
                ->after('contact_groups');


            /*
            |--------------------------------------------------------------------------
            | Legacy updated date
            |--------------------------------------------------------------------------
            */

            $table->date('updated_date')
                ->nullable()
                ->after('join_ids');


            /*
            |--------------------------------------------------------------------------
            | Send Status
            |--------------------------------------------------------------------------
            */

            $table->enum('send_status', [
                'yes',
                'no'
            ])
                ->default('no')
                ->after('updated_date');

            $table->unsignedBigInteger('template_id')
                ->nullable()
                ->after('campaign_id');

            $table->longText('email_content')
                ->nullable()
                ->after('message');


            /*
            |--------------------------------------------------------------------------
            | Responder Status
            |--------------------------------------------------------------------------
            */

            $table->enum('responder_status', [
                'on',
                'off'
            ])
                ->default('on')
                ->after('send_status');

        });
    }

    public function down(): void
    {
        Schema::table('autoresponders', function (Blueprint $table) {

            $table->dropColumn([
                'responder_date',
                'contact_groups',
                'join_ids',
                'updated_date',
                'template_id',
                'email_content',
                'responder_date',
                'send_status',
                'responder_status',
            ]);

        });
    }
};