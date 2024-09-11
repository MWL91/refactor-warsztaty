<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagsToProductsTable extends Migration
{
    /**
     * Apply the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('tags')->nullable(); // Dodanie kolumny `tags` typu JSON
        });
    }

    /**
     * Rollback the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tags'); // Usunięcie kolumny `tags`
        });
    }
}
