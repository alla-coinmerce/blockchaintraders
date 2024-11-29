<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('role');

            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('email', 255)->unique();
            $table->timestamp('welcome_valid_until')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('active')->default(false);
            $table->string('registration_type', 16)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('zipcode', 8)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country_code', 4)->nullable();
            $table->string('nationality_code', 4)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birth_country_code', 4)->nullable();
            $table->boolean('living_in_netherlands')->nullable();
            $table->string('source_of_income', 255)->nullable();
            $table->string('taxable_countries', 255)->nullable();
            $table->string('bsn', 64)->nullable();
            $table->string('coc_number', 64)->nullable();
            $table->string('bank_account_number', 64)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
