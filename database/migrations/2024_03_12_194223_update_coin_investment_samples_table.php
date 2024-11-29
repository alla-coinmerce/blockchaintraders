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
        Schema::table('coin_investment_samples', function (Blueprint $table) {
            $table->string('coin_id', 128)->change();
            $table->bigInteger('value_eurocents')->nullable()->change();
            $table->bigInteger('value_euro_millicents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coin_investment_samples', function (Blueprint $table) {
            $table->string('coin_id', 32)->change();
            $table->integer('value_eurocents')->change();
            $table->dropColumn('value_euro_millicents');
        });
    }
};
