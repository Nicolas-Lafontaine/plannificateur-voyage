<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInTripsTable extends Migration
{
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            // Modification des colonnes existantes
            $table->string('description', 255)->change();
            $table->string('pictures', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            // Revenir aux types de colonnes d'origine
            $table->text('description')->change();
            $table->text('pictures')->change();
        });
    }
}

