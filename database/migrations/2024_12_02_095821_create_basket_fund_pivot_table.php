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
    public function up(): void
    {
        Schema::create('basket_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basket_id')->nullable(false);
            $table->unsignedBigInteger('fund_id')->nullable(false);
            $table->decimal('share_percentage', 5, 2)->nullable(false);
            $table->timestamps();

            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
            $table->foreign('fund_id')->references('id')->on('funds')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_funds');
    }
};