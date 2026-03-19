<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzleRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('puzzle_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->json('feedback')->nullable(); 
            $table->timestamps();
            
            $table->unique(['puzzle_id', 'donor_id']);
            $table->index('rating');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puzzle_ratings');
    }
}