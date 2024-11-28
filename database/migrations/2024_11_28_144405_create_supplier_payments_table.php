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
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('ns'); // Normal saree count
            $table->integer('bs'); // Border saree count
            $table->integer('bbs'); // Big border saree count
            $table->integer('ans');
            $table->integer('abs');
            $table->integer('abbs');
            $table->integer('total_amount');
            $table->integer('given_amount');
            $table->integer('status')->default(0);
            $table->timestamp('start_date')->nullable(); // Date and time
            $table->timestamp('end_date')->nullable(); // Date and time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};
