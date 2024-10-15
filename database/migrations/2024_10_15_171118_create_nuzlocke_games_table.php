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
        Schema::create('nuzlocke_games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('player_count');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->date('start_date')->nullable();
            $table->string('rules')->nullable();
            $table->integer('attempts')->default(1);
            $table->integer('gym_badges')->default(0);
            $table->boolean('elite_four_defeated')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nuzlocke_games');
    }
};
