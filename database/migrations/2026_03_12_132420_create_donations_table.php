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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('GHS');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('donation_reason')->nullable();
            $table->string('custom_reason')->nullable();
            $table->json('paystack_response')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index('transaction_id');
            $table->index('payment_status');
            $table->index('donor_id');
            $table->index('donation_reason');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};