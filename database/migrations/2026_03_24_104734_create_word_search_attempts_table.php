<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('word_search_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained();
            $table->foreignId('word_search_puzzle_id')->constrained('word_search_puzzles');
            $table->integer('score')->default(0);
            $table->json('found_words')->nullable();
            $table->integer('time_taken')->nullable();
            $table->boolean('completed')->default(false);
            $table->string('status')->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('word_search_attempts');
    }
};