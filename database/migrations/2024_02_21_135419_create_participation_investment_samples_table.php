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
        Schema::create('participation_investment_samples', function (Blueprint $table) {
            $table->id();
            
            $table->dateTime('sample_taken_at');
            $table->integer('value_eurocents');
            $table->integer('number_of_participations');
            $table->foreignIdFor(FundValue::class, 'sample_source_id');

            $table->foreignIdFor(FundValue::class); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participation_investment_samples');
    }
};