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
        Schema::create('fund_values', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Fund::class);

            $table->integer('value_eurocents');
            $table->integer('value_dollarcents')->nullable();
            $table->dateTime('date_time');
            $table->date('date');
            $table->time('time');
            $table->integer('number_of_participations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_values');
    }
};
