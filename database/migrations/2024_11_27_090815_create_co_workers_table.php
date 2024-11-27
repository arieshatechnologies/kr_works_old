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
            $table->string('co_worker_name'); // Co-worker's name
            $table->timestamp('date_and_time'); // Date and time
            $table->integer('normal_saree'); // Normal saree count
            $table->integer('border_saree'); // Border saree count
            $table->integer('big_border_saree'); // Big border saree count
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
