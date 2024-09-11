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
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable();       // Dodanie kolumny category
            $table->string('manufacturer')->nullable();   // Dodanie kolumny manufacturer
            $table->string('sku')->nullable();            // Dodanie kolumny sku
            $table->decimal('weight', 8, 2)->nullable();  // Dodanie kolumny weight
            $table->string('dimensions')->nullable();     // Dodanie kolumny dimensions
            $table->string('color')->nullable();          // Dodanie kolumny color
            $table->string('size')->nullable();           // Dodanie kolumny size
            $table->string('material')->nullable();       // Dodanie kolumny material
            $table->string('warranty')->nullable();       // Dodanie kolumny warranty
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');      // Usunięcie kolumny category
            $table->dropColumn('manufacturer'); // Usunięcie kolumny manufacturer
            $table->dropColumn('sku');          // Usunięcie kolumny sku
            $table->dropColumn('weight');       // Usunięcie kolumny weight
            $table->dropColumn('dimensions');   // Usunięcie kolumny dimensions
            $table->dropColumn('color');        // Usunięcie kolumny color
            $table->dropColumn('size');         // Usunięcie kolumny size
            $table->dropColumn('material');     // Usunięcie kolumny material
            $table->dropColumn('warranty');     // Usunięcie kolumny warranty
        });
    }
};
