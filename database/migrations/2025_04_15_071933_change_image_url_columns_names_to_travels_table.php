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
            $table->string('image_url_carrousel')->default('images/travels/default_travel_image_carrousel.jpg')->change();
            $table->string('image_url_card')->default('images/travels/default_travel_image_card.jpg')->after('image_url_carrousel');
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
