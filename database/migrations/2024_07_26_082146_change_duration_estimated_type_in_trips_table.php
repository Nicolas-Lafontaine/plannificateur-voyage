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
        Schema::table('trips', function (Blueprint $table) {
            // Change the type of the duration_estimated column to time
            $table->time('duration_estimated')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            // Revert the type of the duration_estimated column to timestamp
            $table->timestamp('duration_estimated')->change();
        });
    }
};
