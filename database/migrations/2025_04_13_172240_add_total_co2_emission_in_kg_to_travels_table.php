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
        Schema::table('travels', function (Blueprint $table) {
            $table->unsignedInteger('total_co2_emission_in_kg')->default(0)->after('total_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travels', function (Blueprint $table) {
            //
        });
    }
};
