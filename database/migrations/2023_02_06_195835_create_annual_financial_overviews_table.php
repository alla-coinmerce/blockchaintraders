<?php

use App\Models\User;
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
        Schema::create('annual_financial_overviews', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->unsignedInteger('year');
            $table->string('original_file_name', 255);
            $table->string('storage_path', 255);

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
        Schema::dropIfExists('annual_financial_overviews');
    }
};
