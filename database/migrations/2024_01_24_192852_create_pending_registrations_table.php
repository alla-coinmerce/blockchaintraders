<?php

use App\Models\User;
use App\Models\UserDocument;
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
        Schema::create('pending_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);

            $table->string('fund_name', 255);
            $table->string('desired_participation_date', 255);
            $table->string('desired_amount', 255);

            $table->foreignIdFor(UserDocument::class, 'identification')->nullable();
            $table->foreignIdFor(UserDocument::class, 'bank_statement')->nullable();
            $table->foreignIdFor(UserDocument::class, 'coc_extract')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_registrations');
    }
};
