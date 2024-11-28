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
        // Rename the table from 'supplierdetails' to 'suppliers' if it exists
        if (Schema::hasTable('supplierdetails')) {
            Schema::rename('supplierdetails', 'suppliers');
        } else {
            // If the table does not exist, create the 'suppliers' table directly
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->text("address"); // Allows longer addresses
                $table->string("phone_no", 20); // Limited to 20 characters
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('suppliers')) {
            Schema::rename('suppliers', 'supplierdetails'); // Revert the name change
        }

        // Optionally drop the table if it exists
        Schema::dropIfExists('suppliers');
    }
};
