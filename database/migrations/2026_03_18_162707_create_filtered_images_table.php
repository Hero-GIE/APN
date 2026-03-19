<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('filtered_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('original_image');
            $table->string('filtered_image');
            $table->string('filter_type')->default('petition'); 
            $table->string('status')->default('active');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('donors')->onDelete('cascade');
            $table->index('user_id');
            $table->index('filter_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('filtered_images');
    }
};