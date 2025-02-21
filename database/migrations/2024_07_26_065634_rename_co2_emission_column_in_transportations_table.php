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
        Schema::table('transportations', function (Blueprint $table) {
            $table->renameColumn('co2_emission_per_km', 'co2_emission_per_km_grams');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transportations', function (Blueprint $table) {
            $table->renameColumn('co2_emission_per_km_grams', 'co2_emission_per_km');
        });
    }};
