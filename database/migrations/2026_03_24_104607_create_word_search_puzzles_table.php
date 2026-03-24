<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('word_search_puzzles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('grid_size')->default(10);
            $table->json('grid')->nullable(); 
            $table->json('words'); 
            $table->json('word_positions')->nullable(); 
            $table->string('difficulty')->default('intermediate');
            $table->integer('points')->default(100);
            $table->integer('time_limit')->nullable(); 
            $table->integer('attempts_allowed')->default(3);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('featured_image')->nullable();
            $table->integer('play_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('word_search_puzzles');
    }
};