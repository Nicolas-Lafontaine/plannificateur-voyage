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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arrival_location')->constrained('locations')->onDelete('cascade');
            $table->foreignId('departure_location')->constrained('locations')->onDelete('cascade');
            $table->foreignId('transportation_id')->constrained('transportations')->onDelete('cascade');
            $table->foreignId('commentary_id')->nullable()->constrained('commentaries')->onDelete('cascade');
            $table->integer('days_spent_at_destination');
            $table->decimal('length_in_km');
            $table->timestamp('duration_estimated');
            $table->text('description'); // Utiliser text pour un champ TEXT
            $table->text('pictures'); // Utiliser text pour un champ TEXT
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
