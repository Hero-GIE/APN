<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzlesTable extends Migration
{
    public function up()
    {
        Schema::create('puzzles', function (Blueprint $table) {
            $table->id();
            
            // Fix the foreign key constraint
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('puzzle_categories')
                  ->nullOnDelete(); 
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('type'); 
            $table->string('difficulty');
            $table->json('content'); 
            $table->json('settings')->nullable(); 
            $table->json('metadata')->nullable(); 
            $table->integer('base_points')->default(10);
            $table->integer('bonus_points')->default(0);
            $table->string('featured_image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('countries')->nullable(); 
            $table->json('tags')->nullable();
            $table->integer('time_limit')->nullable();
            $table->integer('attempts_allowed')->default(3);
            $table->integer('hints_allowed')->default(2);
            $table->boolean('requires_membership')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_timed')->default(false);
            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('show_explanations')->default(true);
            $table->integer('play_count')->default(0);
            $table->float('average_rating')->default(0);
            $table->integer('total_ratings')->default(0);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['category_id', 'type', 'difficulty']);
            $table->index('is_featured');
            $table->index('play_count');
            $table->index('published_at');
            $table->fullText(['title', 'short_description', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('puzzles');
    }
}