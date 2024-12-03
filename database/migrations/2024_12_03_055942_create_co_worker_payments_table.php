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
        Schema::create('co_worker_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('co_worker_id'); // Co-worker ID
            $table->integer('total_sarees'); // Total sarees distributed
            $table->integer('returned_sarees'); // Total returned sarees
            $table->integer('total_amount'); // Total payment calculated
            $table->integer('paid_amount'); // Amount paid
            $table->integer('balance_amount'); // Remaining balance
            $table->integer('status')->default(0); // Payment status (0=unpaid, 1=partially paid, 2=fully paid)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('co_worker_payments');
    }
};
