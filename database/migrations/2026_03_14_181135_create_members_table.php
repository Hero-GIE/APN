<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('donor_id')->unsigned();
            $table->enum('membership_type', ['monthly', 'annual'])->default('monthly');
            $table->enum('status', ['active', 'expired', 'cancelled', 'pending'])->default('active');
            
            // Fix for timestamp default values
            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->nullable();
            
            $table->timestamp('renewal_reminder_sent_at')->nullable();
            $table->integer('renewal_count')->default(0);
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('donor_id')
                  ->references('id')
                  ->on('donors')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};