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
            // $table->dropColumn('duration_estimated');
            // $table->unsignedInteger('days_spent_at_destination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            // $table->integer('duration_estimated')->nullable();
            // $table->dropColumn('days_spent_at_destination');
        });
    }
};
