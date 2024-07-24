<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDescriptionAndPicturesInTripsTable extends Migration
{
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->text('description')->change();
        });
    }

    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('description', 255)->change();
        });
    }
}
