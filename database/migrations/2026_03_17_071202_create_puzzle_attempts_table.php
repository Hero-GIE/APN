<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzleAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('puzzle_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->integer('score')->default(0);
            $table->integer('max_score')->default(0);
            
            
            $table->integer('time_taken')->nullable();
            $table->integer('hints_used')->default(0);
            $table->json('answers')->nullable();
            $table->json('feedback')->nullable();
            $table->json('question_times')->nullable(); 
            $table->json('metadata')->nullable(); 
            $table->boolean('completed')->default(false);
            $table->integer('attempt_number')->default(1);
            $table->string('status')->default('in_progress'); 
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['donor_id', 'puzzle_id', 'attempt_number']);
            $table->index(['donor_id', 'status']);
            $table->index('completed');
            $table->index('score');
            $table->index('started_at');
            $table->index('completed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puzzle_attempts');
    }
}