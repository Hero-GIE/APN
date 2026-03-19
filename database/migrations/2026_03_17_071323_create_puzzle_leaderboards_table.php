<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzleLeaderboardsTable extends Migration
{
    public function up()
    {
        Schema::create('puzzle_leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->integer('best_score')->default(0);
            $table->integer('best_time')->nullable();
            $table->integer('total_attempts')->default(0);
            $table->integer('rank')->nullable();
            $table->json('achievements')->nullable();
            $table->timestamps();
            
            $table->unique(['puzzle_id', 'donor_id']);
            $table->index(['puzzle_id', 'best_score', 'best_time']);
            $table->index('rank');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puzzle_leaderboards');
    }
}