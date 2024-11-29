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
        Schema::table('funds', function (Blueprint $table) {
            $table->boolean('auto_update_enabled')->default(false)->nullable();
            $table->boolean('extrapolate_enabled')->default(false)->nullable();
            $table->float('extrapolation_factor', 10, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->dropColumn('auto_update_enabled');
            $table->dropColumn('extrapolate_enabled');
            $table->dropColumn('extrapolation_factor');
        });
    }
};
