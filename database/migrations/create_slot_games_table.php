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
        Schema::create('slot_games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('single_number_chance');
            $table->string('double_number_chance');
            $table->string('jackpot_number_chance');
            $table->string('loosing_number_chance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_games');
    }
};
