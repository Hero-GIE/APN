<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('donor_id')->unsigned();
            $table->bigInteger('member_id')->unsigned();
            $table->string('transaction_id')->unique(); 
            $table->enum('membership_type', ['monthly', 'annual']);
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('GHS');
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['success', 'pending', 'failed'])->default('pending');
            $table->json('paystack_response')->nullable();
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
                  
            $table->index('transaction_id');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_payments');
    }
};