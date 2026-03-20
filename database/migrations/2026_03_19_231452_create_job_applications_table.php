<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_opportunities')->onDelete('cascade');
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, reviewed, shortlisted, rejected, hired
            $table->string('cover_letter')->nullable();
            $table->string('resume_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('applied_at');
            $table->timestamps();
            
            $table->unique(['job_id', 'donor_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
};