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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->integer('ns');
            $table->integer('rns')->default(0);;
            $table->integer('bs');
            $table->integer('rbs')->default(0);
            $table->integer('bbs');
            $table->integer(column: 'rbbs')->default(0);
            $table->integer(column: 'a_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
