<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzleQuestionsTable extends Migration
{
   public function up()
{
    Schema::create('puzzle_questions', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('puzzle_id')
              ->constrained()
              ->onDelete('cascade');
        
        $table->string('question');
        $table->text('question_html')->nullable();
        $table->json('options')->nullable();
        $table->string('correct_answer');
        $table->json('incorrect_answers')->nullable();
        $table->json('distractors')->nullable();
        $table->text('explanation')->nullable();
        $table->text('educational_note')->nullable();
        $table->text('fun_fact')->nullable();
        $table->string('image')->nullable();
        $table->string('video_url')->nullable();
        $table->json('metadata')->nullable();
        $table->integer('points')->default(10);
        $table->integer('order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        
        $table->index('order');
    });
}

    public function down()
    {
        Schema::dropIfExists('puzzle_questions');
    }
}