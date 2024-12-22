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
        Schema::create('co_workers', function (Blueprint $table) {
            $table->id();
            $table->integer('co_worker_id'); // Co-worker's name
            $table->integer('supplier_id'); // supplier's name
            $table->timestamp('date_and_time'); // Date and time
            $table->integer('ns'); // Normal saree count
            $table->integer('bs'); // Border saree count
            $table->integer('bbs'); // Big border saree count
            $table->integer('rns')->default(0); // return
            $table->integer('rbs')->default(0);// return
            $table->integer('rbbs')->default(0); // return
            $table->integer('status')->default(0); // return
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('co_workers');
    }
};
