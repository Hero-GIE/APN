<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonorAchievementsTable extends Migration
{
    public function up()
    {
        Schema::create('donor_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained('puzzle_achievements')->onDelete('cascade');
            $table->foreignId('puzzle_id')->nullable()->constrained()->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamp('earned_at');
            $table->timestamps();
            
            $table->unique(['donor_id', 'achievement_id']);
            $table->index('earned_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donor_achievements');
    }
}