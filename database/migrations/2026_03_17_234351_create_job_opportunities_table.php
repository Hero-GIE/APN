// database/migrations/2024_01_01_000003_create_job_opportunities_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('description');
            $table->string('company');
            $table->string('company_logo')->nullable();
            $table->string('location');
            $table->string('city');
            $table->string('country');
            $table->string('job_type'); 
            $table->string('category'); 
            $table->string('category_color')->default('indigo'); 
            $table->string('experience_level'); 
            $table->string('salary_range')->nullable(); 
            $table->string('badge_type')->nullable();
            $table->string('badge_color')->default('green'); 
            $table->date('posted_date');
            $table->date('application_deadline')->nullable();
            $table->string('application_url')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_opportunities');
    }
};