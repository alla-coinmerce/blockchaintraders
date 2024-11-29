<?php

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
        Schema::create('coin_investment_samples', function (Blueprint $table) {
            $table->id();

            $table->string('coin_id', 32);
            $table->string('coin_name', 128);

            $table->dateTime('sample_taken_at');
            $table->integer('value_eurocents');
            $table->float('qty');

            $table->foreignIdFor(FundValue::class); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_investment_samples');
    }
};
