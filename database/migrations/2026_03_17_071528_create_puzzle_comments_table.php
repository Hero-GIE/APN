<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzleCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('puzzle_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('puzzle_comments')->onDelete('cascade');
            $table->text('comment');
            $table->integer('likes')->default(0);
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_edited')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['puzzle_id', 'created_at']);
            $table->index('is_approved');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puzzle_comments');
    }
}