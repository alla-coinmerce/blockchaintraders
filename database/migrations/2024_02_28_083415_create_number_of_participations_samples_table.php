<?php

use App\Models\Fund;
use App\Models\FundValue;
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
        Schema::create('number_of_participations_samples', function (Blueprint $table) {
            $table->id();

            $table->dateTime('sample_taken_at');

            $table->foreignIdFor(Fund::class);
            $table->foreignIdFor(FundValue::class); 

            $table->integer('number_of_participations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number_of_participations_samples');
    }
};
