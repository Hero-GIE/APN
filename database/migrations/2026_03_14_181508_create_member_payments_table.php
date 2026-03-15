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
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('donor_id')->unsigned();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('donation_id')->unsigned();
            $table->enum('membership_type', ['monthly', 'annual']);
            $table->decimal('amount', 10, 2);
            $table->timestamp('payment_date')->useCurrent();
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            
            $table->timestamps();
            
            $table->foreign('donor_id')
                  ->references('id')
                  ->on('donors')
                  ->onDelete('cascade');
                  
            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
                  ->onDelete('cascade');
                  
            $table->foreign('donation_id')
                  ->references('id')
                  ->on('donations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_payments');
    }
};