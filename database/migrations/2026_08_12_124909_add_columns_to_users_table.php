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
        Schema::table('users', function (Blueprint $table) {

            $table->string('username', 100)->nullable()->after('email');

            $table->integer('industry_id')->nullable();

            $table->string('company_name', 255)->nullable();
            $table->string('company_address', 255)->nullable();
            $table->string('company_phone', 20)->nullable();
            $table->string('company_fax', 20)->nullable();

            $table->string('city', 100)->nullable();
            $table->string('country', 200)->nullable();
            $table->string('state', 200)->nullable();
            $table->string('zip', 20)->nullable();

            $table->text('intresta_id')->nullable();
            $table->text('additional_details')->nullable();

            $table->string('billing_first_name', 200)->nullable();
            $table->string('billing_last_name', 200)->nullable();
            $table->string('billing_address', 255)->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 200)->nullable();
            $table->string('billing_country', 200)->nullable();
            $table->string('billing_zip', 6)->nullable();

            $table->integer('package_id')->nullable();
            //$table->integer('additional_email')->nullable();

            $table->enum('payment_option', ['paypal', 'stripe', 'bank'])->nullable();

            $table->string('bank_name', 255)->nullable();
            $table->string('bank_city_name', 255)->nullable();
            $table->string('micr_number', 255)->nullable();
            $table->string('cheque_number', 255)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('cheque_type', 255)->nullable();

            $table->enum('status', ['Active', 'Deactive'])->default('Deactive');

            //$table->enum('downgrade', ['yes', 'no'])->nullable();

            $table->string('account_type', 15)->default('user');

            //$table->string('session_id')->nullable();

            //$table->boolean('email_footer')->default(false);

            $table->boolean('masking_allowed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'username',
                'industry_id',
                'company_name',
                'company_address',
                'company_phone',
                'company_fax',
                'city',
                'country',
                'state',
                'zip',
                'intresta_id',
                'additional_details',
                'billing_first_name',
                'billing_last_name',
                'billing_address',
                'billing_city',
                'billing_state',
                'billing_country',
                'billing_zip',
                'created_date',
                'updated_date',
                'package_id',
                //'additional_email',
                'payment_option',
                'bank_name',
                'bank_city_name',
                'micr_number',
                'cheque_number',
                'cheque_date',
                'cheque_type',
                'status',
                //'downgrade',
                'account_type',
                //'session_id',
                //'email_footer',
                'masking_allowed',
            ]);
        });
    }
};
