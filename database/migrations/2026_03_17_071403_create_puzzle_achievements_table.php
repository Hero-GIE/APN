<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzleAchievementsTable extends Migration
{
    public function up()
    {
        Schema::create('puzzle_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->json('criteria');
            $table->integer('points')->default(0);
            $table->string('rarity'); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('rarity');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puzzle_achievements');
    }
}