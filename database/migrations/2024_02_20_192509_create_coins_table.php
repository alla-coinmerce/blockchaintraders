<?php

use App\Models\Fund;
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
        Schema::create('coin_investments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Fund::class);

            $table->string('coin_id', 32);
            $table->string('coin_name', 128);
            $table->float('qty', 10, 6);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_investments');
    }
};
